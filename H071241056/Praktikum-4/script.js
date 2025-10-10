// Konstanta dan Variabel Global
const COLORS = ['red', 'blue', 'green', 'yellow'];
const NUMBERS = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
const ACTION_CARDS = ['skip', 'reverse', 'draw2'];
const WILD_CARDS = ['wild', 'wild4'];
let pendingDraw = 0;   // jumlah penalti kartu yang harus diambil
let pendingType = "";  // tipe penalti aktif: "draw2" atau "wild4"
let botUnoPressed = false;

let deck = [];
let playerHand = [];
let botHand = [];
let discardPile = [];
let currentPlayer = 'player';
let currentColor = '';
let currentNumber = '';
let gameStarted = false;
let playerBalance = 5000;
let currentBet = 0;
let unoPressed = false;
let unoTimer = null;

// DOM Elements
const balanceElement = document.getElementById('balance');
const betAmountInput = document.getElementById('betAmount');
const placeBetButton = document.getElementById('placeBet');
const playerHandElement = document.getElementById('playerHand');
const botHandElement = document.getElementById('botHand');
const discardPileElement = document.getElementById('discardPile');
const drawDeckElement = document.getElementById('drawDeck');
const playerCardCountElement = document.getElementById('playerCardCount');
const botCardCountElement = document.getElementById('botCardCount');
const gameMessageElement = document.getElementById('gameMessage');
const actionLogElement = document.getElementById('actionLog');
const unoButton = document.getElementById('unoButton');
const callUnoButton = document.getElementById('callUnoButton');
const colorModal = document.getElementById('colorModal');
const gameOverScreen = document.getElementById('gameOverScreen');
const restartGameButton = document.getElementById('restartGameButton');


// Inisialisasi Game
function initGame() {
    createDeck();
    shuffleDeck();
    updateBalanceDisplay();
    setupEventListeners();
    updateDeckDisplay();
    preloadCardImages();
    //pemilihan warna disembunyikan
    colorModal.style.display = 'none';
    
    showMessage('Selamat datang! Pasang taruhan untuk memulai.');
}

// Buat Deck Kartu
function createDeck() {
    deck = [];

    // Kartu angka (0–9) untuk setiap warna → masing-masing hanya 1
    COLORS.forEach(color => {
        NUMBERS.forEach(number => {
            deck.push({ type: 'number', color, value: number });
        });

        // Kartu aksi → masing-masing hanya 1
        ACTION_CARDS.forEach(action => {
            deck.push({ type: 'action', color, value: action });
        });
    });

    // Kartu wild → masing-masing hanya 1
    deck.push({ type: 'wild', color: 'black', value: 'wild' });
    deck.push({ type: 'wild', color: 'black', value: 'wild4' });
}

// Acak Deck
function shuffleDeck() {
    for (let i = deck.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [deck[i], deck[j]] = [deck[j], deck[i]];
    }
}

// Setup Event Listeners
function setupEventListeners() {
    placeBetButton.addEventListener('click', startRound);
    unoButton.addEventListener('click', pressUno);
    callUnoButton.addEventListener('click', callUno);
    restartGameButton.addEventListener('click', restartGame);
    
    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const color = e.target.dataset.color;
            handleWildColorSelection(color);
        });
    });
}

// Mulai Ronde - RESET UNO STATE
function startRound() {
    const betAmount = parseInt(betAmountInput.value);
    
    if (betAmount < 100 || betAmount > playerBalance) {
        showMessage('Taruhan tidak valid! Minimal $100, maksimal sesuai saldo.');
        return;
    }
    
    currentBet = betAmount;
    playerBalance -= betAmount;
    updateBalanceDisplay();
    
    // Reset game state
    playerHand = [];
    botHand = [];
    discardPile = [];
    gameStarted = true;
    currentPlayer = 'player';
    unoPressed = false;
    botUnoPressed = false;
    pendingDraw = 0;
    pendingType = "";
    
    // Clear UNO timer jika ada
    if (unoTimer) {
        clearTimeout(unoTimer);
    }
    
    // Bagikan kartu
    dealCards();
    
    // Letakkan kartu pertama di discard pile
    let firstCard;
    do {
        if (deck.length === 0) {
            showMessage('Deck kosong! Mengacak ulang...');
            createDeck();
            shuffleDeck();
        }
        firstCard = deck.pop();
    } while (firstCard.type === 'wild');
    
    discardPile.push(firstCard);
    currentColor = firstCard.color;
    currentNumber = firstCard.value;
    
    updateUI();
    showMessage('Game dimulai! Giliran Anda.');
    
    // Nonaktifkan betting section
    placeBetButton.disabled = true;
    betAmountInput.disabled = true;
}

// Bagikan Kartu
function dealCards() {
    for (let i = 0; i < 7; i++) {
        if (deck.length > 0) playerHand.push(deck.pop());
        if (deck.length > 0) botHand.push(deck.pop());
    }
}

// Update UI
function updateUI() {
    updateHandDisplay();
    updateDiscardPile();
    updateCardCounts();
    updateGameControls();
}

// Mapping untuk mendapatkan nama file gambar
function getCardImageName(card) {
    if (card.type === 'wild') {
        if (card.value === 'wild4') return 'plus_4'; 
        return 'wild'; 
    }

    if (card.type === 'action') {
        let actionName = card.value;
        if (card.value === 'draw2') actionName = 'plus2';
        if (card.value === 'reverse') actionName = 'reverse';
        if (card.value === 'skip') actionName = 'skip';
        return `${card.color}_card/${card.color}_${actionName}`;
    }

    if (card.type === 'number') {
        return `${card.color}_card/${card.color}_${card.value}`;
    }

    return `${card.color}_card`;
}

// teks alt 
function getCardAltText(card) {
    if (!card) return 'Kartu tak dikenal';
    if (card.type === 'wild') {
        return card.value === 'wild4' ? 'Kartu Wild +4' : 'Kartu Wild';
    }
    if (card.type === 'action') {
        const actionName = card.value === 'draw2' ? 'Tambah 2' : card.value;
        return `${capitalize(card.color)} - ${actionName}`;
    }
    if (card.type === 'number') {
        return `${capitalize(card.color)} - Angka ${card.value}`;
    }
    return 'Kartu UNO';
}

function capitalize(s) {
    if (!s) return s;
    return s.charAt(0).toUpperCase() + s.slice(1);
}

// Buat elemen kartu
function createCardElement(card, index, clickable = false) {
    //membuat  container utama untuk kartu
    const cardElement = document.createElement('div');
    const imageName = getCardImageName(card);

    // set class CSS - tambah 'playable' jika kartu bisa diklik
    cardElement.className = `card ${clickable ? 'playable' : ''}`;

    // Buat tag <img> untuk gambar kartu
    const img = document.createElement('img');
    img.src = `assets/${imageName}.png`;
    img.alt = getCardAltText(card);
    img.className = 'card-img';
    img.style.width = '100%';
    img.style.height = '100%';
    img.style.objectFit = 'cover';

    cardElement.appendChild(img); //tambah gambar ke kartu
    
    if (gameStarted && currentPlayer === 'player' && clickable) {
        cardElement.style.cursor = 'pointer';
            img.addEventListener('click', (e) => {
                console.log('Image inside card clicked:', index, card);
                // If card is clickable and it's player's turn, attempt to play the card
                if (clickable && gameStarted && currentPlayer === 'player') {
                    playCard(index);
                }
            });
        
        cardElement.addEventListener('mouseenter', () => {
            if (clickable && isValidPlay(card)) {
                cardElement.style.transform = 'translateY(-15px)';
                cardElement.style.boxShadow = '0 12px 30px rgba(0, 0, 0, 0.6)';
                cardElement.style.zIndex = '10';
            }
        });
        
        cardElement.addEventListener('mouseleave', () => {
            cardElement.style.transform = 'translateY(0px)';
            cardElement.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.3)';
            cardElement.style.zIndex = '1';
        });
    } else {
        cardElement.style.cursor = 'default';
    }
    
    return cardElement;
}

// Update tampilan tangan
function updateHandDisplay() {
    playerHandElement.innerHTML = '';
    botHandElement.innerHTML = '';
   
    playerHand.forEach((card, index) => {
        const playable = isValidPlay(card);
        // Wild selalu bisa diklik, meskipun ada kartu valid lain
        const clickable = playable || card.type === 'wild';
        const cardElement = createCardElement(card, index, clickable);

        if (playable || card.type === 'wild') {
            cardElement.classList.add('playable');
            cardElement.style.opacity = '1';
        } else {
            cardElement.classList.add('unplayable');
            cardElement.style.opacity = '0.6';
        }

        playerHandElement.appendChild(cardElement);
    });

    
    botHand.forEach(() => {
        const cardBack = document.createElement('div');
        cardBack.className = 'card card-back';
        const img = document.createElement('img');
        img.src = "assets/card_back.png";
        img.alt = 'Kartu tertutup (bot)';
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover';
        img.className = 'card-img';
        cardBack.appendChild(img);
        botHandElement.appendChild(cardBack);
    });
}

// Update discard pile
function updateDiscardPile() {
    discardPileElement.innerHTML = '';
    if (discardPile.length > 0) {
        const topCard = discardPile[discardPile.length - 1];
        const cardElement = createCardElement(topCard, -1, false);
        discardPileElement.appendChild(cardElement);
    }
}

// Update deck display
function updateDeckDisplay() {
    drawDeckElement.innerHTML = '';
    const deckCard = document.createElement('div');
    deckCard.className = 'card card-back';
    const img = document.createElement('img');
    img.src = "assets/card_back.png";
    img.alt = 'Deck kartu (klik untuk mengambil)';
    img.style.width = '100%';
    img.style.height = '100%';
    img.style.objectFit = 'cover';
    img.className = 'card-img';
    deckCard.appendChild(img);
    deckCard.style.cursor = 'pointer';
    deckCard.addEventListener('click', drawCard);
    drawDeckElement.appendChild(deckCard);
}

// Update jumlah kartu
function updateCardCounts() {
    playerCardCountElement.textContent = playerHand.length;
    botCardCountElement.textContent = botHand.length;
}

// Update kontrol game
function updateGameControls() {
    // draw button removed; drawing via clicking the deck element
    unoButton.disabled = playerHand.length !== 1 || !gameStarted || unoPressed;
    callUnoButton.disabled = botHand.length !== 1 || !gameStarted || botUnoPressed;
}

// Tampilkan pesan
function showMessage(message) {
    gameMessageElement.textContent = message;
    addToActionLog(message);
}

// Tambah ke log aksi
function addToActionLog(message) {
    const logEntry = document.createElement('div');
    logEntry.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;
    actionLogElement.appendChild(logEntry);
    actionLogElement.scrollTop = actionLogElement.scrollHeight;
}

// Update saldo
function updateBalanceDisplay() {
    balanceElement.textContent = playerBalance;
    betAmountInput.max = playerBalance;
}

// Preload images
function preloadCardImages() {
    const imagesToPreload = [];
    
    // Preload number cards
    COLORS.forEach(color => {
        NUMBERS.forEach(number => {
            imagesToPreload.push(`${color}_card/${color}_${number}.png`);
        });
    });

    // Preload action cards
    COLORS.forEach(color => {
        imagesToPreload.push(`${color}_card/${color}_plus2.png`);
        imagesToPreload.push(`${color}_card/${color}_skip.png`);
        imagesToPreload.push(`${color}_card/${color}_reverse.png`);
    });
    
    // PERBAIKAN: Preload wild cards dengan nama yang benar
    imagesToPreload.push('wild.png');
    imagesToPreload.push('plus_4.png'); // bukan 'wild_plus4.png'
    imagesToPreload.push('card_back.png');
    
    // Preload semua gambar
    imagesToPreload.forEach(imageName => {
        const img = new Image();
        img.src = `assets/${imageName}`;
        
        img.onerror = () => {
            console.warn(`Gambar tidak ditemukan: assets/${imageName}`);
        };
        
        img.onload = () => {
            console.log(`Gambar berhasil load: assets/${imageName}`);
        };
    });
}

function drawCards(target, count) {
    for (let i = 0; i < count; i++) {
        if (deck.length === 0) reshuffleDeck();
        // Jika setelah reshuffle deck masih kosong, hentikan untuk menghindari undefined
        if (deck.length === 0) {
            console.warn('Tidak cukup kartu untuk ditarik. Deck dan discard tidak cukup.');
            break;
        }
        if (target === 'player') playerHand.push(deck.pop());
        else botHand.push(deck.pop());
    }
}


// Mainkan kartu
function playCard(cardIndex) {
    if (currentPlayer !== 'player' || !gameStarted) return;
    
    const card = playerHand[cardIndex];

    // Cek kartu valid
    if (!isValidPlay(card)) {
        showMessage('Kartu tidak valid! Pilih kartu dengan warna/angka yang sama.');
        return;
    }

    // 🔹 VALIDASI HANYA UNTUK WILD DRAW FOUR
    if (card.value === 'wild4') {
        const hasOtherNonWildPlayable = playerHand.some(c => 
            c !== card && 
            c.type !== 'wild' && 
            isValidPlay(c)
        );
        
        if (hasOtherNonWildPlayable) {
            showMessage('Wild Draw Four hanya boleh dimainkan jika tidak ada kartu lain (non-wild) yang bisa dimainkan!');
            return;
        }
    }

    // 🔹 TANGANI WILD BIASA (bisa dimainkan kapan saja)
    if (card.type === 'wild' && card.value !== 'wild4') {
        showColorSelectionModal(selectedColor => {
            currentColor = selectedColor;
            discardPile.push(card);
            playerHand.splice(cardIndex, 1);

            updateUI();
            handleCardEffect(card);

            // Timer UNO
            if (playerHand.length === 1 && !unoPressed) {
                startUnoTimer();
            }

            if (playerHand.length === 0) {
                endRound('player');
                return;
            }

            setTimeout(botPlay, 1500);
        });
        return;
    }

    // 🔹 TANGANI WILD +4 (dengan validasi khusus)
    if (card.value === 'wild4') {
        showColorSelectionModal(selectedColor => {
            currentColor = selectedColor;
            discardPile.push(card);
            playerHand.splice(cardIndex, 1);

            drawCards('bot', 4);
            showMessage('Bot mengambil 4 kartu!');

            updateUI();

            // Timer UNO
            if (playerHand.length === 1 && !unoPressed) {
                startUnoTimer();
            }

            setTimeout(botPlay, 1500);
        });
        return;
    }

    // 🔹 UNTUK KARTU BIASA (angka, reverse, skip, draw two)
    playerHand.splice(cardIndex, 1);
    discardPile.push(card);
    currentColor = card.color;
    currentNumber = card.value;

    handleCardEffect(card);
    updateUI();

    // Timer UNO
    if (playerHand.length === 1 && !unoPressed) {
        startUnoTimer();
    }

    if (playerHand.length === 0) {
        endRound('player');
        return;
    }

    if (currentPlayer === 'bot') {
        setTimeout(botPlay, 1500);
    } else {
        showMessage('🎮 Giliran Anda lagi!');
    }
}

// Ambil kartu - TAMBAH RESET UNO STATE
function drawCard() {
    if (currentPlayer !== 'player' || !gameStarted) return;

    // Kalau ada penalti dan player pilih ambil kartu → eksekusi penalti
    if (pendingDraw > 0) {
        checkPendingDraw();
        return;
    }

    if (deck.length === 0) {
        reshuffleDeck();
    }

    const drawnCard = deck.pop();
    playerHand.push(drawnCard);

    // Reset UNO state karena kartu bertambah
    if (playerHand.length > 1) {
        unoPressed = false;
        clearTimeout(unoTimer);
        unoButton.disabled = true;
    }

    showMessage(`Anda mengambil kartu`);

    if (isValidPlay(drawnCard)) {
        showMessage('Kartu yang diambil bisa dimainkan! Klik kartu untuk memainkannya.');
    } else {
        // Jika kartu yang diambil tidak bisa dimainkan, lanjutkan giliran ke bot tanpa pesan tambahan
        currentPlayer = 'bot';
        setTimeout(botPlay, 1500);
    }

    updateUI();
}

// Cek validitas kartu
function isValidPlay(card) {
    // 🔹 WILD BIASA SELALU BISA DIMAINKAN
    if (card.type === 'wild' && card.value !== 'wild4') {
            return true;
        }

    if (card.value === 'wild4'){
        return true;
    }

    // Jika masih ada penalti menumpuk
    if (pendingDraw > 0) {
        if (pendingType === 'draw2') {
            return card.value === 'draw2' || card.value === 'wild4';
        }
        if (pendingType === 'wild4') {
            return card.value === 'wild4';
        }
    }

    // Normal rule UNO
    if (card.color === currentColor) return true;
    if (card.value === currentNumber) return true;


    return false;
}

// Cek apakah ada kartu valid
function hasValidCard(hand) {
    return hand.some(card => isValidPlay(card));
}

// Handle efek kartu
function handleCardEffect(card) {
    switch (card.value) {
        case 'skip':
            showMessage(`⏭️ ${currentPlayer === 'player' ? 'Bot' : 'Anda'} dilewati!`);
            break;
            
        case 'reverse':
            showMessage(`🔄 Arah permainan dibalik!`);
            break;

        case 'draw2':
            pendingDraw += 2;
            pendingType = (pendingType === 'wild4') ? 'wild4' : 'draw2';
            showMessage(`➕ ${currentPlayer === 'player' ? 'Bot' : 'Anda'} harus mengambil 2 kartu!`);
            currentPlayer = (currentPlayer === 'player') ? 'bot' : 'player';
            break;

        case 'wild4':
            pendingDraw += 4;
            pendingType = 'wild4';
            showMessage(`➕ ${currentPlayer === 'player' ? 'Bot' : 'Anda'} harus mengambil 4 kartu!`);
            currentPlayer = (currentPlayer === 'player') ? 'bot' : 'player';
            break;

        default:
            // Normal card → giliran pindah
            currentPlayer = (currentPlayer === 'player') ? 'bot' : 'player';
    }

    addToActionLog(`Kartu ${getCardDisplayValue(card)} dimainkan`);
}

function checkPendingDraw() {
    if (pendingDraw > 0) {
        if (currentPlayer === 'player') {
            showMessage(`➕ Anda harus ambil ${pendingDraw} kartu!`);
            for (let i = 0; i < pendingDraw; i++) {
                if (deck.length > 0) playerHand.push(deck.pop());
            }
            currentPlayer = 'bot';
            setTimeout(botPlay, 1500);
        } else {
            showMessage(`➕ Bot harus ambil ${pendingDraw} kartu!`);
            for (let i = 0; i < pendingDraw; i++) {
                if (deck.length > 0) botHand.push(deck.pop());
            }
            currentPlayer = 'player';
        }

        pendingDraw = 0;
        pendingType = "";
        updateUI();
    }
}

// Dapatkan nilai tampilan kartu
function getCardDisplayValue(card) {
    if (card.type === 'number') return card.value;
    if (card.value === 'skip') return 'Skip';
    if (card.value === 'reverse') return 'Reverse';
    if (card.value === 'draw2') return '+2';
    if (card.value === 'wild') return 'Wild';
    if (card.value === 'wild4') return 'Wild +4';
    return card.value;
}

// Modal pilih warna
function showColorSelectionModal(callback) {
    const modal = document.getElementById('colorModal');
    if (!modal) {
        console.error("Elemen #colorModal tidak ditemukan di HTML!");
        return;
    }

    modal.style.display = 'block';

    const colorButtons = modal.querySelectorAll('.color-btn');
    colorButtons.forEach(button => {
        button.onclick = () => {
            const selectedColor = button.dataset.color;

            // Tutup modal
            modal.style.display = 'none';

            // Jalankan callback setelah memilih warna
            if (callback) callback(selectedColor);
        };
    });
}

// Handle pemilihan warna
function handleWildColorSelection(color) {
    currentColor = color;
    currentNumber = '';
    colorModal.style.display = 'none';
    
    showMessage(`🎨 Warna berubah menjadi: ${color}`);
    
    // Setelah memilih warna, lanjutkan efek kartu
    const lastCard = discardPile[discardPile.length - 1];
    if (lastCard && lastCard.type === 'wild') {
        // Simpan current player sebelum efek
        const previousPlayer = currentPlayer;
        handleCardEffect(lastCard);
        
        console.log(`Wild card - Before effect: ${previousPlayer}, After effect: ${currentPlayer}`);
    }
    
    updateUI();
    
    // Cek jika game belum berakhir
    if (playerHand.length === 0) {
        endRound('player');
        return;
    }
    
    // Jika setelah efek kartu giliran bot, beri waktu
    if (currentPlayer === 'bot') {
        console.log('Wild card - Continuing to bot play...');
        setTimeout(botPlay, 1500);
    } else {
        console.log('Wild card - Player continues turn...');
        showMessage('🎮 Giliran Anda lagi!');
    }
}

// Logika bot
function botPlay() {
    if (currentPlayer !== 'bot' || !gameStarted) {
        console.log('Bot cannot play: not bot turn or game not started');
        return;
    }

    // Kalau ada penalti menumpuk → bot ambil
    if (pendingDraw > 0) {
        checkPendingDraw();
        return;
    }

    showMessage('🤖 Giliran Bot...');

    // Prefer non-wild valid cards
    const nonWildValid = botHand.filter(card => isValidPlay(card) && card.type !== 'wild');
    if (nonWildValid.length > 0) {
        const randomIndex = Math.floor(Math.random() * nonWildValid.length);
        const selectedCard = nonWildValid[randomIndex];
        playBotCard(selectedCard);
        return;
    }

    // No non-wild valid cards. Consider wilds (wild or wild4) only if they are valid under rules
    const wildValid = botHand.filter(card => isValidPlay(card) && card.type === 'wild');
    if (wildValid.length > 0) {
        // For wild4, ensure no other non-wild playable cards exist (already checked above)
        const randomIndex = Math.floor(Math.random() * wildValid.length);
        const selectedWild = wildValid[randomIndex];
        playBotCard(selectedWild);
        return;
    }

    // If no valid cards at all, draw
    botDrawCard();
}

// Bot memainkan kartu
function playBotCard(card) {
    const cardIndex = botHand.findIndex(c => c === card);
    botHand.splice(cardIndex, 1);
    discardPile.push(card);
    
    showMessage(`🤖 Bot memainkan: ${getCardDisplayValue(card)}`);
    
    if (card.type === 'wild') {
        const randomColor = COLORS[Math.floor(Math.random() * COLORS.length)];
        currentColor = randomColor;
        currentNumber = '';
        showMessage(`🤖 Bot memilih warna: ${randomColor}`);
    } else {
        currentColor = card.color;
        currentNumber = card.value;
    }
    
    // Simpan current player sebelum efek
    const previousPlayer = currentPlayer;
    handleCardEffect(card);
    
    // Handle UNO untuk bot
    if (botHand.length === 1 && !botUnoPressed) {
        showMessage('🤖 Bot mengatakan UNO!');
        botUnoPressed = true;
    }
    
    if (botHand.length === 0) {
        endRound('bot');
        return;
    }
    
    updateUI();
    
    // Jika setelah efek kartu giliran masih bot (karena skip/reverse), main lagi
    if (currentPlayer === 'bot') {
        setTimeout(botPlay, 1500);
    } else {
        showMessage('🎮 Giliran Anda!');
        // Reset UNO state ketika giliran berpindah ke player
        botUnoPressed = false;
    }
}

// Bot mengambil kartu
function botDrawCard() {
    if (deck.length === 0) {
        reshuffleDeck();
    }
    
    const drawnCard = deck.pop();
    botHand.push(drawnCard);
    
    showMessage(`🤖 Bot mengambil 1 kartu`);
    
    // Reset UNO state karena kartu bertambah
    if (botHand.length > 1) {
        botUnoPressed = false;
    }
    
    if (isValidPlay(drawnCard)) {
        showMessage('🤖 Bot memainkan kartu yang diambil!');
        setTimeout(() => playBotCard(drawnCard), 1000);
    } else {
        currentPlayer = 'player';
        showMessage('🎮 Giliran Anda!');
        updateUI();
    }
}

// Acak ulang deck
function reshuffleDeck() {
    if (discardPile.length <= 1) return;
    
    const topCard = discardPile.pop();
    deck = [...discardPile];
    discardPile = [topCard];
    
    shuffleDeck();
    showMessage('🃏 Deck diacak ulang!');
}

// Timer UNO
function startUnoTimer() {
    unoPressed = false;
    unoButton.disabled = false;
    showMessage('⚠️ Anda tinggal 1 kartu! Tekan UNO dalam 5 detik!');

    // Clear timer sebelumnya jika ada
    if (unoTimer) {
        clearTimeout(unoTimer);
    }

    unoTimer = setTimeout(() => {
        // Cegah hukuman jika giliran sudah berpindah (misalnya bot sudah main)
        if (currentPlayer !== 'player') return;

        if (!unoPressed && playerHand.length === 1) {
            showMessage('❌ Anda lupa tekan UNO! +2 kartu penalti.');
            
            drawCards('player', 2); // gunakan fungsi drawCards agar konsisten
            updateUI();
        }

        unoButton.disabled = true;
    }, 5000);
}

// Tombol UNO
function pressUno() {
    if (playerHand.length === 1 && !unoPressed) {
        unoPressed = true;
        unoButton.disabled = true;
        showMessage('🎉 UNO!');
        clearTimeout(unoTimer);
    } else {
        showMessage('❌ Tidak bisa tekan UNO! Kartu tidak tepat.');
    }
}

// Panggil UNO lawan
function callUno() {
    if (botHand.length === 1 && !botUnoPressed && gameStarted) {
        showMessage('🎯 Bot lupa UNO! +2 kartu penalti.');
        // Gunakan helper drawCards yang sudah menangani reshuffle jika deck kosong
        drawCards('bot', 2);
        botUnoPressed = true;
        updateUI();
    } else {
        showMessage('❌ Tidak bisa memanggil UNO!');
    }
    callUnoButton.disabled = true;
}

function showGameOverScreen() {
    gameOverScreen.style.display = 'flex';
    gameStarted = false;
    placeBetButton.disabled = true;
    betAmountInput.disabled = true;
    showMessage('💸 Saldo Anda habis!');
}

function restartGame() {
    // Reset semua variabel penting
    playerBalance = 5000;
    currentBet = 0;
    gameStarted = false;
    playerHand = [];
    botHand = [];
    discardPile = [];
    deck = [];

    // Sembunyikan overlay
    gameOverScreen.style.display = 'none';

    // Aktifkan kembali input taruhan
    placeBetButton.disabled = false;
    betAmountInput.disabled = false;
    updateBalanceDisplay();
    showMessage('💰 Game dimulai ulang! Pasang taruhan baru untuk bermain lagi.');

    // Re-inisialisasi deck dan tampilan
    createDeck();
    shuffleDeck();
    updateDeckDisplay();
    updateUI();
}

// Akhiri ronde
function endRound(winner) {
    gameStarted = false;
    
    if (winner === 'player') {
        playerBalance += currentBet * 2;
        showMessage(`🎊 Selamat! Anda menang! +$${currentBet * 2}`);
    } else {
        showMessage(`😞 Bot menang! Anda kalah $${currentBet}`);
    }
    
    updateBalanceDisplay();
    
    placeBetButton.disabled = false;
    betAmountInput.disabled = false;
    
    if (playerBalance <= 0) {
        showGameOverScreen();
    }

    
    updateUI();
}

document.addEventListener('DOMContentLoaded', initGame);