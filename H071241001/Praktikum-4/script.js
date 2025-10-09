// === DOM Elements ===
// Mengambil elemen-elemen HTML yang digunakan untuk tampilan dan interaksi game
const bettingScreen = document.getElementById('betting-screen'); // Layar taruhan
const gameBoard = document.getElementById('game-board');         // Layar utama permainan
const gameOverScreen = document.getElementById('game-over-screen'); // Layar game over
const startGameBtn = document.getElementById('start-game-btn');  // Tombol mulai game
const balanceDisplay = document.getElementById('balance-display'); // Tampilan saldo
const betInput = document.getElementById('bet-input');           // Input taruhan
const playerHandDiv = document.getElementById('player-hand');    // Area kartu player
const botHandDiv = document.getElementById('bot-hand');          // Area kartu bot
const discardPileDiv = document.getElementById('discard-pile');  // Area kartu teratas
const deckPile = document.getElementById('deck');                // Area deck (draw pile)
const statusText = document.getElementById('status-text');       // Status giliran
const passBtn = document.getElementById('pass-btn');             // Tombol lewati giliran
const unoBtn = document.getElementById('uno-btn');               // Tombol UNO
const callUnoBtn = document.getElementById('call-uno-btn');      // Tombol panggil UNO (oleh bot)
const chooseColorDiv = document.getElementById('choose-color');  // Area pilih warna wild
const colorBtns = document.querySelectorAll('.color-btn');       // Tombol-tombol warna wild
const restartBtn = document.getElementById('restart-btn');       // Tombol restart game

// === Game Variables ===
// Variabel-variabel utama untuk menyimpan status permainan
let playerHand = [];      // Kartu di tangan player
let botHand = [];         // Kartu di tangan bot
let deck = [];            // Sisa kartu di deck
let discardPile = [];     // Kartu yang sudah dibuang (discard pile)
let playerBalance = 5000; // Saldo awal player
let currentBet = 0;       // Taruhan saat ini
let isPlayerTurn = true;  // Status giliran player
let unoCalled = false;    // Status apakah player sudah panggil UNO
let pendingWildIdx = null;// Index kartu wild yang sedang menunggu pilihan warna

// === Game Logic ===

// 1. Membuat Deck Kartu UNO
function createDeck() {
    // Daftar warna dan value kartu
    const colors = ['red', 'yellow', 'green', 'blue'];
    const values = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'skip', 'reverse', 'draw2'];
    const wildCards = ['wild', 'wild_draw4'];
    let newDeck = [];

    // Tambahkan kartu berwarna (angka dan aksi)
    for (let color of colors) {
        for (let value of values) {
            newDeck.push({ value, color });           // Satu kartu angka 0 per warna
            if (value !== '0') newDeck.push({ value, color }); // Dua kartu untuk selain 0
        }
    }
    // Tambahkan kartu wild dan wild_draw4 (masing-masing 4 buah)
    for (let i = 0; i < 4; i++) {
        newDeck.push({ value: wildCards[0], color: 'any' });
        newDeck.push({ value: wildCards[1], color: 'any' });
    }
    return newDeck;
}

// 2. Mengocok Deck dengan algoritma Fisher-Yates
function shuffleDeck(deck) {
    for (let i = deck.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [deck[i], deck[j]] = [deck[j], deck[i]];
    }
}

// 3. Memulai Permainan Baru
function startGame() {
    // Ambil nilai taruhan dari input
    currentBet = parseInt(betInput.value);
    // Validasi taruhan
    if (isNaN(currentBet) || currentBet < 100 || currentBet > playerBalance) {
        alert("Taruhan tidak valid!");
        return;
    }

    // Tampilkan board, sembunyikan betting screen
    bettingScreen.classList.remove('active');
    gameBoard.classList.add('active');

    // Buat dan kocok deck
    deck = createDeck();
    shuffleDeck(deck);

    // Bagikan 7 kartu ke player dan bot
    playerHand = deck.splice(0, 7);
    botHand = deck.splice(0, 7);

    // Ambil kartu pertama untuk discard pile, tidak boleh wild_draw4
    let firstCard = deck.pop();
    while (firstCard.value === 'wild_draw4') {
        deck.unshift(firstCard);
        firstCard = deck.pop();
    }
    discardPile = [firstCard];

    // Jika kartu pertama wild, pilih warna random
    if (firstCard.color === 'any') {
        const colors = ['red', 'yellow', 'green', 'blue'];
        firstCard.color = colors[Math.floor(Math.random() * colors.length)];
    }

    isPlayerTurn = true; // Player mulai duluan
    unoCalled = false;   // Reset status UNO
    renderGame();        // Render tampilan awal
}

// Mendapatkan nama file gambar kartu sesuai asset
function getCardImage(card) {
    // Mapping nama value ke nama file asset
    let valueMap = {
        'draw2': 'plus2',
        'wild_draw4': 'plus_4',
        'wild': 'wild',
        'skip': 'skip',
        'reverse': 'reverse'
    };
    let value = valueMap[card.value] || card.value;
    if (card.color === 'any') {
        return `${value}.png`;
    } else {
        return `${card.color}_${value}.png`;
    }
}

// Render tampilan game (kartu, status, tombol)
function renderGame() {
    // Update saldo di tampilan
    balanceDisplay.textContent = playerBalance;

    // Ambil kartu teratas dari discard pile
    let topCard = discardPile.length > 0 ? discardPile[discardPile.length - 1] : null;

    // Render kartu player
    playerHandDiv.innerHTML = '';
    playerHand.forEach((card, index) => {
        const cardDiv = document.createElement('div');
        cardDiv.className = 'card';
        let cardImage = getCardImage(card);
        cardDiv.style.backgroundImage = `url('assets/${cardImage}')`;
        cardDiv.dataset.cardIndex = index;
        // Hanya bisa klik kartu saat giliran player dan tidak sedang pilih warna wild
        if (isPlayerTurn && chooseColorDiv.style.display === "none") {
            cardDiv.addEventListener('click', playerPlayCard);
        }
        playerHandDiv.appendChild(cardDiv);
    });

    // Render kartu bot (tertutup)
    botHandDiv.innerHTML = '';
    botHand.forEach(() => {
        const cardDiv = document.createElement('div');
        cardDiv.className = 'card card-back';
        botHandDiv.appendChild(cardDiv);
    });

    // Render kartu teratas di discard pile
    discardPileDiv.innerHTML = '';
    if (topCard) {
        const topCardDiv = document.createElement('div');
        topCardDiv.className = 'card';
        let topCardImage = getCardImage(topCard);
        topCardDiv.style.backgroundImage = `url('assets/${topCardImage}')`;
        discardPileDiv.appendChild(topCardDiv);
    }

    // Status giliran
    statusText.textContent = isPlayerTurn ? "Ronde dimulai. Giliran Anda." : "Giliran Bot.";

    // Tampilkan tombol PASS jika tidak ada kartu yang bisa dimainkan
    if (isPlayerTurn && topCard && !playerHand.some(card => canPlay(card, topCard))) {
        passBtn.style.display = "inline-block";
    } else {
        passBtn.style.display = "none";
    }

    // Tampilkan tombol UNO jika kartu tinggal 2
    if (isPlayerTurn && playerHand.length === 2) {
        unoBtn.style.display = "inline-block";
    } else {
        unoBtn.style.display = "none";
    }

    // Tampilkan tombol Panggil UNO jika player tinggal 1 kartu dan belum klik UNO
    if (!isPlayerTurn && playerHand.length === 1 && !unoCalled) {
        callUnoBtn.style.display = "inline-block";
    } else {
        callUnoBtn.style.display = "none";
    }
}

// Cek apakah kartu bisa dimainkan (warna sama, angka/aksi sama, atau wild)
function canPlay(card, topCard) {
    return (
        card.color === topCard.color ||
        card.value === topCard.value ||
        card.color === 'any'
    );
}

// Fungsi saat player klik kartu
function playerPlayCard(e) {
    // Hanya bisa main jika giliran player dan tidak sedang pilih warna wild
    if (!isPlayerTurn || chooseColorDiv.style.display !== "none") return;
    const idx = parseInt(e.currentTarget.dataset.cardIndex);
    const card = playerHand[idx];
    const topCard = discardPile[discardPile.length - 1];

    // Jika kartu bisa dimainkan
    if (canPlay(card, topCard)) {
        // Jika wild, tampilkan pilihan warna
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

// Fungsi untuk benar-benar main kartu (setelah pilih warna jika wild)
function playCard(idx, card, chosenColor) {
    discardPile.push(card);      // Masukkan ke discard pile
    playerHand.splice(idx, 1);   // Hapus dari tangan player

    // Jika wild, set warna sesuai pilihan
    if (card.color === 'any' && chosenColor) {
        card.color = chosenColor;
    }

    // Efek kartu aksi
    if (card.value === 'draw2') {
        setTimeout(() => {
            if (deck.length >= 2) {
                botHand.push(deck.pop());
                botHand.push(deck.pop());
            }
            // Setelah efek selesai, lanjut ke bot
            unoCalled = false;
            isPlayerTurn = false;
            renderGame();
            setTimeout(botTurn, 800);
        }, 400);
        return;
    }
    if (card.value === 'wild_draw4') {
        setTimeout(() => {
            for (let i = 0; i < 4 && deck.length > 0; i++) {
                botHand.push(deck.pop());
            }
            unoCalled = false;
            isPlayerTurn = false;
            renderGame();
            setTimeout(botTurn, 800);
        }, 400);
        return;
    }
    if (card.value === 'skip' || card.value === 'reverse') {
        setTimeout(() => {
            // Lewati giliran lawan (bot)
            unoCalled = false;
            isPlayerTurn = true;
            renderGame();
        }, 400);
        return;
    }

    // Cek penalti UNO jika player tinggal 1 kartu dan lupa klik UNO
    if (playerHand.length === 1 && !unoCalled) {
        setTimeout(() => {
            alert("Kamu lupa panggil UNO! Dapat penalti 2 kartu.");
            playerHand.push(deck.pop());
            playerHand.push(deck.pop());
            unoCalled = false;
            renderGame();
        }, 400);
    }

    // Cek menang
    if (playerHand.length === 0) {
        playerBalance += currentBet;
        setTimeout(() => {
            alert("Kamu MENANG!");
            endRound();
        }, 300);
        return;
    }

    unoCalled = false;
    isPlayerTurn = false;
    renderGame();
    setTimeout(botTurn, 800);
}

// Fungsi giliran bot
function botTurn() {
    const topCard = discardPile[discardPile.length - 1];
    let idx = botHand.findIndex(card => canPlay(card, topCard));
    if (idx !== -1) {
        let card = botHand[idx];
        discardPile.push(card);
        botHand.splice(idx, 1);

        // Jika kartu wild, bot pilih warna random
        if (card.color === 'any') {
            const colors = ['red', 'yellow', 'green', 'blue'];
            card.color = colors[Math.floor(Math.random() * colors.length)];
        }

        // Efek kartu aksi
        if (card.value === 'draw2') {
            setTimeout(() => {
                playerHand.push(deck.pop());
                playerHand.push(deck.pop());
                renderGame();
            }, 400);
        }
        if (card.value === 'wild_draw4') {
            setTimeout(() => {
                for (let i = 0; i < 4 && deck.length > 0; i++) {
                    playerHand.push(deck.pop());
                }
                renderGame();
            }, 400);
        }
        if (card.value === 'skip' || card.value === 'reverse') {
            // Lewati giliran lawan (player)
            setTimeout(() => {
                isPlayerTurn = false;
                renderGame();
                setTimeout(botTurn, 800);
            }, 400);
            return; // Jangan lanjut ke player turn
        }

        // Cek menang bot
        if (botHand.length === 0) {
            playerBalance -= currentBet;
            setTimeout(() => {
                alert("Bot MENANG!");
                endRound();
            }, 300);
            return;
        }
    } else {
        // Bot ambil kartu dari deck jika tidak bisa main
        if (deck.length > 0) {
            botHand.push(deck.pop());
        }
    }
    isPlayerTurn = true;
    renderGame();
}

// Fungsi player draw card dari deck
function playerDrawCard() {
    if (!isPlayerTurn) return;
    if (deck.length > 0) {
        playerHand.push(deck.pop());
        renderGame();
    }
}

// Fungsi mengakhiri ronde dan cek saldo
function endRound() {
    if (playerBalance <= 0) {
        gameBoard.classList.remove('active');
        gameOverScreen.classList.add('active');
    } else {
        // Kembali ke betting screen
        gameBoard.classList.remove('active');
        bettingScreen.classList.add('active');
        betInput.value = '';
    }
    renderGame();
}

// Event pilih warna wild (saat player main wild/wild_draw4)
colorBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        const color = btn.dataset.color;
        const idx = pendingWildIdx;
        const card = playerHand[idx];
        chooseColorDiv.style.display = "none";
        playCard(idx, card, color);
        pendingWildIdx = null;
    });
});

// Tombol pass/lewati giliran
passBtn.addEventListener('click', function() {
    if (!isPlayerTurn) return;
    if (deck.length > 0) {
        playerHand.push(deck.pop());
    }
    isPlayerTurn = false;
    renderGame();
    setTimeout(botTurn, 800);
});

// Tombol UNO (player klik saat tinggal 2 kartu)
unoBtn.addEventListener('click', function() {
    unoCalled = true;
    alert("UNO dipanggil!");
    renderGame();
});

// Tombol panggil UNO (bot memanggil jika player lupa)
callUnoBtn.addEventListener('click', function() {
    if (playerHand.length === 1 && !unoCalled) {
        alert("Bot memanggil UNO! Kamu kena penalti 2 kartu.");
        playerHand.push(deck.pop());
        playerHand.push(deck.pop());
        unoCalled = false;
        renderGame();
    }
});

// === Event Listeners ===
// Tombol mulai game, draw card, restart
startGameBtn.addEventListener('click', startGame);
deckPile.addEventListener('click', playerDrawCard);
restartBtn.addEventListener('click', () => location.reload());

// Saat halaman dimuat, tampilkan saldo awal
document.addEventListener('DOMContentLoaded', () => {
    balanceDisplay.textContent = playerBalance;
});