const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

const angkaAcak = Math.floor(Math.random() * 100) + 1;
let jumlahTebakan = 0;

function tanyaTebakan() {
  rl.question("Masukkan salah satu dari angka 1 sampai 100: ", (jawaban) => {
    try {
      const tebakan = parseInt(jawaban);
      if (isNaN(tebakan)) {
        throw new Error(
          "Input bukan angka! Silakan masukkan angka yang valid."
        );
      }

      jumlahTebakan++;

      if (tebakan > angkaAcak) {
        console.log("Terlalu tinggi! Coba lagi.");
        tanyaTebakan();
      } else if (tebakan < angkaAcak) {
        console.log("Terlalu rendah! Coba lagi.");
        tanyaTebakan();
      } else {
        console.log(
          `Selamat! kamu berhasil menebak angka ${angkaAcak} dengan benar.`
        );
        console.log(`Sebanyak ${jumlahTebakan}x percobaan.`);
        rl.close();
      }
    } catch (error) {
      console.log(error.message);
      tanyaTebakan();
    }
  });
}

tanyaTebakan();
