// === DOM Elements ===
const bettingScreen = document.getElementById('betting-screen');
const gameBoard = document.getElementById('game-board');
const gameOverScreen = document.getElementById('game-over-screen');
const startGameBtn = document.getElementById('start-game-btn');
const balanceDisplay = document.getElementById('balance-display');
const betInput = document.getElementById('bet-input');
const playerHandDiv = document.getElementById('player-hand');
const botHandDiv = document.getElementById('bot-hand');
const discardPileDiv = document.getElementById('discard-pile');
const deckPile = document.getElementById('deck');
const statusText = document.getElementById('status-text');
const passBtn = document.getElementById('pass-btn');
const unoBtn = document.getElementById('uno-btn');
const callUnoBtn = document.getElementById('call-uno-btn');
const chooseColorDiv = document.getElementById('choose-color');
const colorBtns = document.querySelectorAll('.color-btn');
const restartBtn = document.getElementById('restart-btn');

// === Game Variables ===
let playerHand = [];
let botHand = [];
let deck = [];
let discardPile = [];
let playerBalance = 5000;
let currentBet = 0;
let isPlayerTurn = true;
let unoCalled = false;
let pendingWildIdx = null;
let unoTimerId = null;

// === Game Logic ===

// 1. Membuat Deck Kartu UNO
function createDeck() {
    const colors = ['red', 'yellow', 'green', 'blue'];
    const values = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'skip', 'reverse', 'draw2'];
    const wildCards = ['wild', 'wild_draw4'];
    let newDeck = [];

    for (let color of colors) {
        for (let value of values) {
            newDeck.push({ value, color });
            if (value !== '0') newDeck.push({ value, color });
        }
    }
    for (let i = 0; i < 4; i++) {
        newDeck.push({ value: wildCards[0], color: 'any' });
        newDeck.push({ value: wildCards[1], color: 'any' });
    }
    return newDeck;
}

// 2. Mengocok Deck
function shuffleDeck(deck) {
    for (let i = deck.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [deck[i], deck[j]] = [deck[j], deck[i]];
    }
}

// 3. Memulai Permainan Baru
function startGame() {
    // validasi taruhan
    currentBet = parseInt(betInput.value);
    if (isNaN(currentBet) || currentBet < 100 || currentBet > playerBalance) {
        alert("Taruhan tidak valid! Minimal $100 dan maksimal sesuai saldo Anda.");
        return;
    }

    bettingScreen.classList.remove('active');
    gameBoard.classList.add('active');

    deck = createDeck();
    shuffleDeck(deck);


// bagi kartu
    playerHand = deck.splice(0, 7);
    botHand = deck.splice(0, 7);

//
    let firstCard = deck.pop();
    while (firstCard.value === 'wild_draw4') {
        deck.unshift(firstCard);
        shuffleDeck(deck);
        firstCard = deck.pop();
    }
    discardPile = [firstCard];

    if (firstCard.color === 'any') {
        const colors = ['red', 'yellow', 'green', 'blue'];
        firstCard.color = colors[Math.floor(Math.random() * colors.length)];
    }

    isPlayerTurn = true;
    unoCalled = false;
    renderGame();
}

// 4. Mendapatkan Nama File Gambar Kartu
function getCardImage(card) {
    const value = card.value;
    const color = card.color;

    if (value === 'wild') {
        return 'wild.png';
    }
    if (value === 'wild_draw4') {
        return 'plus_4.png';
    }

    const valueMap = {
        'draw2': 'plus2',
        'skip': 'skip',
        'reverse': 'reverse'
    };
    
    const mappedValue = valueMap[value] || value;
    
    return `${color}_${mappedValue}.png`;
}

// 5. Render Tampilan Game 
function renderGame() {
    const balanceSpans = document.querySelectorAll('#balance-display');
    balanceSpans.forEach(span => span.textContent = playerBalance);

    const topCard = discardPile.length > 0 ? discardPile[discardPile.length - 1] : null;

    playerHandDiv.innerHTML = '';
    playerHand.forEach((card, index) => {
        const cardDiv = document.createElement('div');
        cardDiv.className = 'card';
        cardDiv.dataset.cardIndex = index;
        cardDiv.style.backgroundImage = `url('assets/${getCardImage(card)}')`;
        cardDiv.title = `${card.color} ${card.value}`;
        
        // Kode fallback text yang mengganggu sudah dihapus dari sini

        if (isPlayerTurn && chooseColorDiv.style.display === "none") {
            cardDiv.addEventListener('click', playerPlayCard);
        }
        playerHandDiv.appendChild(cardDiv);
    });

    botHandDiv.innerHTML = '';
    botHand.forEach(() => {
        const cardDiv = document.createElement('div');
        cardDiv.className = 'card card-back';
        botHandDiv.appendChild(cardDiv);
    });

    discardPileDiv.innerHTML = '';
    if (topCard) {
        const topCardDiv = document.createElement('div');
        topCardDiv.className = 'card';
        topCardDiv.style.backgroundImage = `url('assets/${getCardImage(topCard)}')`;
        topCardDiv.title = `${topCard.color} ${topCard.value}`;
        
        // Kode fallback text yang mengganggu sudah dihapus dari sini
        
        discardPileDiv.appendChild(topCardDiv);

        const currentColor = topCard.color;
        const validColors = ['red', 'green', 'blue', 'yellow'];

        if (validColors.includes(currentColor)) {
            discardPileDiv.style.borderColor = currentColor;
        } else {
            discardPileDiv.style.borderColor = 'transparent';
        }
        
        const turnText = isPlayerTurn ? "Giliran Anda." : "Giliran Bot.";
        const colorName = currentColor.charAt(0).toUpperCase() + currentColor.slice(1);
        statusText.textContent = `${turnText} Warna saat ini: ${colorName}.`;

    } else {
        statusText.textContent = isPlayerTurn ? "Giliran Anda." : "Giliran Bot.";
        discardPileDiv.style.borderColor = 'transparent';
    }

    passBtn.style.display = (isPlayerTurn && topCard && !playerHand.some(card => canPlay(card, topCard))) ? "inline-block" : "none";
    // tekan uno jika tinggal 2 kartu
    unoBtn.style.display = (isPlayerTurn && playerHand.length === 2) ? "inline-block" : "none";
    callUnoBtn.style.display = (isPlayerTurn && botHand.length === 1) ? "inline-block" : "none";
}


// 6. Cek apakah kartu bisa dimainkan
function canPlay(card, topCard) {
    return card.color === topCard.color || card.value === topCard.value || card.color === 'any';
}

// 7. Fungsi saat player klik kartu
function playerPlayCard(e) {
    if (!isPlayerTurn || chooseColorDiv.style.display !== "none") return;
    const idx = parseInt(e.currentTarget.dataset.cardIndex);
    const card = playerHand[idx];
    const topCard = discardPile[discardPile.length - 1];

    // pilih warna untuk wild
    if (canPlay(card, topCard)) {
        if (card.color === 'any') {
            chooseColorDiv.style.display = "block";
            pendingWildIdx = idx;
            return;
        }
        playCard(idx, card);
    } else {
        alert("Kartu tidak bisa dimainkan!");
    }
}

// 8. Logika Memainkan Kartu
// turun kartu berkurang 1
function playCard(idx, card, chosenColor) {
    if (unoTimerId) clearTimeout(unoTimerId);

    discardPile.push(card);
    playerHand.splice(idx, 1);

    if (card.color === 'any' && chosenColor) card.color = chosenColor;

    if (card.value === 'draw2' || card.value === 'wild_draw4') {
        renderGame();
        setTimeout(() => {
            const amountToDraw = (card.value === 'draw2') ? 2 : 4;
            for (let i = 0; i < amountToDraw && deck.length > 0; i++) botHand.push(deck.pop());
            renderGame();
            checkUnoAndWin();
        }, 400);
        return;
    }
    
    if (card.value === 'skip' || card.value === 'reverse') {
         renderGame();
         return;
    }

    renderGame();
    passTurnToBot();
}

// 9. Fungsi Bantu Baru
function checkUnoAndWin() {
    // cek saldo menang
    if (playerHand.length === 0) {
        playerBalance += currentBet;
        setTimeout(() => {
            alert("Kamu MENANG! +$" + currentBet);
            endRound();
        }, 300);
        return;
    }

    // penalti 5 detik
    if (playerHand.length === 1 && !unoCalled) {
        unoTimerId = setTimeout(() => {
            if (playerHand.length === 1 && !unoCalled && isPlayerTurn) {
                alert("Kamu lupa panggil UNO! Dapat penalti 2 kartu.");
                if (deck.length >= 2) playerHand.push(deck.pop(), deck.pop());
                passTurnToBot();
            }
        }, 5000);
    }
}

function passTurnToBot() {
    checkUnoAndWin();
    if (playerHand.length > 0) {
        isPlayerTurn = false;
        renderGame();
        setTimeout(botTurn, 1000);
    }
}

// 10. Fungsi Giliran Bot
function botTurn() {
    const topCard = discardPile[discardPile.length - 1];
    let playableCardIndex = botHand.findIndex(card => canPlay(card, topCard));
    
    if (playableCardIndex !== -1) {
        let card = botHand.splice(playableCardIndex, 1)[0];
        discardPile.push(card);

        if (card.color === 'any') card.color = ['red', 'yellow', 'green', 'blue'][Math.floor(Math.random() * 4)];
        
        renderGame();

        setTimeout(() => {
            const isActionCard = ['draw2', 'wild_draw4', 'skip', 'reverse'].includes(card.value);
            if (card.value === 'draw2' || card.value === 'wild_draw4') {
                const amount = (card.value === 'draw2') ? 2 : 4;
                for (let i = 0; i < amount && deck.length > 0; i++) playerHand.push(deck.pop());
            }

            // cek saldo kalah
            if (botHand.length === 0) {
                playerBalance -= currentBet;
                alert("Bot MENANG! -$" + currentBet);
                endRound();
                return;
            }
            
            if (isActionCard) {
                setTimeout(botTurn, 1000);
            } else {
                isPlayerTurn = true;
                renderGame();
            }
        }, 600);
    } else {
        if (deck.length > 0) botHand.push(deck.pop());
        isPlayerTurn = true;
        renderGame();
    }
}

// 11. Fungsi Player Ambil Kartu
function playerDrawCard() {
    if (!isPlayerTurn) return;
    // ambil kartu dari deck langsung turun kartu
    if (deck.length > 0) {
        playerHand.push(deck.pop());
        renderGame();
    }
}

// 12. Mengakhiri Ronde
// game over jika saldo habis
function endRound() {
    if (playerBalance <= 0) {
        gameBoard.classList.remove('active');
        gameOverScreen.classList.add('active');
        const finalBalanceSpan = gameOverScreen.querySelector('#balance-display');
        if (finalBalanceSpan) finalBalanceSpan.textContent = "0";
    } else {
        gameBoard.classList.remove('active');
        bettingScreen.classList.add('active');
        betInput.value = '';
    }
    balanceDisplay.textContent = playerBalance;
}

// === Event Listeners ===
colorBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        const idx = pendingWildIdx;
        const card = playerHand[idx];
        chooseColorDiv.style.display = "none";
        playCard(idx, card, btn.dataset.color);
        pendingWildIdx = null;
    });
});

passBtn.addEventListener('click', function() {
    if (!isPlayerTurn) return;
    if (deck.length > 0) playerHand.push(deck.pop());
    renderGame();
    setTimeout(passTurnToBot, 200);
});

unoBtn.addEventListener('click', function() {
    if(playerHand.length <= 2) {
        unoCalled = true;
        alert("UNO!");
        if (unoTimerId) clearTimeout(unoTimerId);
        unoBtn.style.display = "none";
    }
});

// panggil uno bot
callUnoBtn.addEventListener('click', function() {
    if (botHand.length === 1) {
        alert("Anda memanggil UNO pada Bot! Bot kena penalti 2 kartu.");
        if (deck.length >= 2) botHand.push(deck.pop(), deck.pop());
        renderGame();
    }
});

// penjelasan event fungsinya
startGameBtn.addEventListener('click', startGame); 
deckPile.addEventListener('click', playerDrawCard); 
restartBtn.addEventListener('click', () => location.reload());

document.addEventListener('DOMContentLoaded', () => {
    balanceDisplay.textContent = playerBalance;
});