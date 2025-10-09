let playerHand = [];
let botHand = [];
let discardPile = [];
let gameDeck = [];
let balance = 5000;
let bet = 0;
let gameStarted = false;
let currentColor = null;
let playerTurn = true;
let unoTimer = null;
let unoDeclared = false;
let skipNext = false;
let botSaidUno = false;


const colors = ["red", "blue", "green", "yellow"];
const values = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "Skip", "Reverse", "+2"];
let deck = [];

// Build deck
for (let color of colors) {
  for (let value of values) {
    deck.push({ color, value });
  }
}

for (let i = 0; i < 4; i++) {
  deck.push({ color: "wild", value: "Wild" });
  deck.push({ color: "wild", value: "+4" });
}

function shuffle(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
}

function getCardImage(card) {
  if (!card || !card.color) return "card_back.png";

  const color = card.color.toLowerCase();
  const value = card.value;

  if (value === "+2") return `${color}_plus2.png`;
  if (value === "+4") return `plus_4.png`;
  if (value === "Skip") return `${color}_skip.png`;
  if (value === "Reverse") return `${color}_reverse.png`;
  if (!isNaN(value)) return `${color}_${value}.png`;
  if (value === "Wild") return `wild.png`;

  return "card_back.png";
}

const wagerInput = document.getElementById("wager-input");
const setWagerBtn = document.getElementById("set-wager-btn");
const wagerDisplay = document.getElementById("wager-display");
const startBtn = document.getElementById("start-btn");
const drawBtn = document.getElementById("draw-btn");

setWagerBtn.addEventListener("click", () => {
  const wager = parseInt(wagerInput.value);
  if (isNaN(wager) || wager < 100) {
    showMessage("Minimum wager is $100!");
    return;
  }
  if (wager > balance) {
    showMessage("You can't bet more than your balance!");
    return;
  }
  bet = wager;
  wagerDisplay.textContent = `Wager: $${bet}`;
  wagerDisplay.classList.remove("hidden");
  startBtn.classList.remove("hidden");
  showMessage("Wager set! Press Start to begin.");
});

startBtn.addEventListener("click", () => {
  startBtn.classList.add("hidden");
  document.getElementById("wager-section").classList.add("hidden");
  startGame();
});

function startGame() {
  const newDeck = shuffle([...deck]);
  playerHand = newDeck.splice(0, 7);
  botHand = newDeck.splice(0, 7);
  discardPile = [newDeck.shift()];
  gameDeck = newDeck;
  playerTurn = true;
  unoDeclared = false;
  
  const topCard = discardPile[0];
  currentColor = topCard.color === "wild" ? colors[Math.floor(Math.random() * 4)] : topCard.color;
  
  gameStarted = true;
  renderGame();
  showMessage(`Round started! Playing for $${bet}`);
  botSaidUno = false;

}

function updateColorDisplay() {
  const colorDisplay = document.getElementById("color-display");
  if (currentColor) {
    colorDisplay.textContent = currentColor.toUpperCase();
    const colorMap = {
      red: "#ef4444",
      blue: "#3b82f6",
      green: "#22c55e",
      yellow: "#ebc44dff"
    };
    colorDisplay.style.color = colorMap[currentColor];
    document.getElementById("current-color").style.borderColor = colorMap[currentColor];
  } else {
    colorDisplay.textContent = "-";
  }
}

function renderGame() {
  const playerHandDiv = document.getElementById("player-hand");
  playerHandDiv.innerHTML = "";

  playerHand.forEach((card, i) => {
    const img = document.createElement("img");
    img.src = `assets/${getCardImage(card)}`;
    img.className = "w-16 h-24 rounded-lg cursor-pointer hover:scale-110 transition-transform";
    img.addEventListener("click", () => playCard(i));
    playerHandDiv.appendChild(img);
  });

  const topCardDiv = document.getElementById("top-card");
  const topCard = discardPile[discardPile.length - 1];
  topCardDiv.innerHTML = "";
  const topImg = document.createElement("img");
  topImg.src = `assets/${getCardImage(topCard)}`;
  topImg.className = "w-30 h-45 rounded-xl shadow-lg";
  topCardDiv.appendChild(topImg);

  // Render bot hand with card back images
  const botHandDiv = document.getElementById("bot-hand");
  botHandDiv.innerHTML = "";
  botHand.forEach(() => {
    const img = document.createElement("img");
    img.src = "assets/card_back.png";
    img.className = "w-12 h-18 rounded-lg shadow-md";
    botHandDiv.appendChild(img);
  });

  document.getElementById("balance").textContent = `Balance: $${balance}`;
  document.getElementById("bot-count").textContent = botHand.length;
  document.getElementById("call-uno-btn").classList.toggle("hidden", !gameStarted);

  updateColorDisplay();
  
  // Enable/disable draw button based on turn
  drawBtn.disabled = !playerTurn;
}

function canPlay(card, topCard) {
  return (
    card.color === currentColor ||
    card.value === topCard.value ||
    card.color === "wild"
  );
}

function playCard(index) {
  if (!playerTurn) {
    showMessage("Wait for bot's turn!");
    return;
  }

  const card = playerHand[index];
  const topCard = discardPile[discardPile.length - 1];

  if (!canPlay(card, topCard)) {
    showMessage("You can't play that card!");
    return;
  }

  playerTurn = false;
  discardPile.push(card);
  playerHand.splice(index, 1);

  if (card.color === "wild") {
    chooseColor("player", () => {
      applyCardEffect(card, "bot");
      renderGame();
      checkWin("player");
      if (gameStarted) setTimeout(botTurn, 1200);
    });
  } else {
    currentColor = card.color;
    applyCardEffect(card, "bot");
    renderGame();
    checkWin("player");
    if (gameStarted) setTimeout(botTurn, 1200);
  }
}

function chooseColor(player, callback) {
  if (player === "player") {
    const picker = document.getElementById("color-picker");
    picker.classList.remove("hidden");

    // hapus dulu event lama supaya gak dobel
    document.querySelectorAll(".color-btn").forEach(btn => {
      btn.replaceWith(btn.cloneNode(true));
    });

    document.querySelectorAll(".color-btn").forEach(btn => {
      btn.addEventListener("click", (e) => {
        const chosen = e.target.dataset.color;
        currentColor = chosen;
        picker.classList.add("hidden");
        showMessage(`You chose ${chosen}!`);
        renderGame();
        if (callback) callback();
      });
    });
  } else {
    // Bot pilih warna otomatis
    const colorCounts = {};
    colors.forEach(c => colorCounts[c] = 0);
    botHand.forEach(card => {
      if (card.color !== "wild") colorCounts[card.color]++;
    });

    let maxColor = "red";
    let maxCount = 0;
    for (let c in colorCounts) {
      if (colorCounts[c] > maxCount) {
        maxCount = colorCounts[c];
        maxColor = c;
      }
    }

    currentColor = maxColor;
    showMessage(`Bot chose ${maxColor}!`);
    if (callback) callback();
  }
}

function botTurn() {
  if (!gameStarted) return;

  // Handle skip effect
  if (skipNext) {
    skipNext = false;
    showMessage("Bot's turn was skipped!");
    playerTurn = true;
    renderGame();
    return;
  }

  playerTurn = false;
  const topCard = discardPile[discardPile.length - 1];
  const playable = botHand.find(c => canPlay(c, topCard));

  if (playable) {
    discardPile.push(playable);
    botHand.splice(botHand.indexOf(playable), 1);

    const afterPlay = () => {
      checkWin("bot");
      handleSkipOrNextTurn();
      renderGame();
    };

    if (playable.color === "wild") {
      chooseColor("bot", () => {
        applyCardEffect(playable, "player");
        showMessage(`Bot played ${playable.value} and chose ${currentColor}!`);
        renderGame();
        afterPlay();
      });
    } else {
      currentColor = playable.color;
      applyCardEffect(playable, "player");
      showMessage(`Bot played ${playable.value}`);
      renderGame();
      afterPlay();
    }
  } else {
    // Bot draws if no playable card
    const draw = gameDeck.shift();
    botHand.push(draw);
    showMessage("Bot drew a card.");
    renderGame();
    handleSkipOrNextTurn();
  }
}

function handleSkipOrNextTurn() {
  if (skipNext) {
    skipNext = false;
    showMessage("Your turn was skipped!");
    playerTurn = false;
    setTimeout(botTurn, 1200);
  } else {
    playerTurn = true;
  }
}

function applyCardEffect(card, target) {
  if (card.value === "+2") {
    drawCards(target, 2);
  } else if (card.value === "+4") {
    drawCards(target, 4);
  } else if (card.value === "Skip" || card.value === "Reverse") {
    skipNext = true;
    showMessage("Turn skipped!");
  }
}

function drawCards(target, count) {
  const cards = drawFromDeck(count);
  if (target === "player") playerHand.push(...cards);
  else botHand.push(...cards);
}

function drawFromDeck(count = 1) {
  // Refill deck if empty
  if (gameDeck.length < count) {
    const lastTop = discardPile.pop(); // keep the top card
    gameDeck = shuffle(discardPile);
    discardPile = [lastTop];
  }

  const cards = gameDeck.splice(0, count);
  return cards;
}


function checkWin(player) {
  if (player === "player" && playerHand.length === 1 && !unoDeclared) {
    showMessage("Press UNO within 5 seconds!");
    unoTimer = setTimeout(() => {
      playerHand.push(...gameDeck.splice(0, 2));
      showMessage("You forgot UNO! +2 penalty!");
      unoDeclared = false;
      renderGame();
    }, 5000);
  } else if (player === "bot" && botHand.length === 1) {
      if (Math.random() < 0.5) {
          botSaidUno = false; // lupa
          showMessage("Bot forgot to say UNO!");
        } else {
          botSaidUno = true;
          showMessage("Bot has UNO!");
        }
  }

  if (playerHand.length === 0) {
    endRound("player");
  } else if (botHand.length === 0) {
    endRound("bot");
  }
}

document.getElementById("uno-btn").addEventListener("click", () => {
  if (!gameStarted) {
    showMessage("Start a game first!");
    return;
  }
  
  if (playerHand.length !== 1) {
    showMessage("You can only declare UNO when you have 1 card left! +2 penalty!");
    playerHand.push(...gameDeck.splice(0, 2));
    renderGame();
    return;
  }
  
  clearTimeout(unoTimer);
  unoDeclared = true;
  showMessage("UNO declared successfully!");
});

function endRound(winner) {
  gameStarted = false;
  playerTurn = false;
  clearTimeout(unoTimer);
  
  if (winner === "player") {
    balance += bet;
    showMessage(`🎉 YOU WIN! +$${bet} (Balance: $${balance})`);
  } else {
    balance -= bet;
    showMessage(`😞 YOU LOSE! -$${bet} (Balance: $${balance})`);
  }

  renderGame()

  if (balance <= 0) {
    setTimeout(gameOver, 2000);
  } else {
    setTimeout(() => {
      document.getElementById("wager-section").classList.remove("hidden");
      wagerInput.value = "";
      wagerDisplay.classList.add("hidden");
      unoDeclared = false;
      showMessage("Set your next wager to play again!");
    }, 2500);
  }
}

function gameOver() {
  showMessage("💔 GAME OVER! You're out of money!");
  document.getElementById("restart-btn").classList.remove("hidden");
}

function showMessage(msg) {
  document.getElementById("message").textContent = msg;
}

drawBtn.addEventListener("click", () => {
  if (!playerTurn) {
    showMessage("Wait for your turn!");
    return;
  }
  
  if (!gameStarted) {
    showMessage("Start a game first!");
    return;
  }

  unoDeclared = false;

  const draw = gameDeck.shift();
  playerHand.push(draw);
  showMessage("You drew a card.");
  renderGame();
  
  playerTurn = false;
  renderGame();
  setTimeout(botTurn, 1200);
});

document.getElementById("restart-btn").addEventListener("click", () => {
  balance = 5000;
  bet = 0;
  gameStarted = false;
  playerTurn = false;
  unoDeclared = false;
  playerHand = [];
  botHand = [];
  discardPile = [];
  document.getElementById("restart-btn").classList.add("hidden");
  document.getElementById("wager-section").classList.remove("hidden");
  wagerDisplay.classList.add("hidden");
  showMessage("Set your wager to start a new game!");
  renderGame();
});

document.getElementById("call-uno-btn").addEventListener("click", () => {
  if (!gameStarted) {
    showMessage("Start a game first!");
    return;
  }

  // kalau bot punya 1 kartu tapi belum sempat bilang UNO
  if (botHand.length === 1 && !botSaidUno) {
    botHand.push(...gameDeck.splice(0, 2));
    showMessage("You caught the bot! Bot forgot UNO! +2 penalty!");
  } else {
    // salah tuduh
    playerHand.push(...gameDeck.splice(0, 2));
    showMessage("Wrong call! You get +2 penalty!");
  }

  renderGame();
});
