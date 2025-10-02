
const readline = require('readline');

// Create interface for input/output
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const target = Math.floor(Math.random() * 100) + 1;
let attempts = 0;

function askGuess() {
  rl.question("\nMasukkan salah satu dari angka 1 sampai 100: ", (input) => {
    const guess = parseInt(input); 

    if (isNaN(guess)) {
      console.log("\nHarus angka ya!");
      askGuess();
    } else if (guess > target) {
      console.log("\nTerlalu tinggi! Coba lagi.");
       attempts++;
      askGuess();
    } else if (guess < target) {
      console.log("\nTerlalu rendah! Coba lagi.");
       attempts++;
      askGuess();
    } else {
       attempts++;
      console.log(`\nSelamat! kamu berhasil menebak angka ${target} dengan benar.`);
      console.log(`\nSebanyak ${attempts}x percobaan.`);
      rl.close();
    }
  });
}

askGuess();


    