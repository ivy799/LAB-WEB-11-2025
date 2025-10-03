const { log } = require("console");
const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

rl.question("Masukkan harga barang: ", (hargaAwal) => {
  if (isNaN(hargaAwal)) {
    console.log("Input tidak valid");
  } else {
    rl.question(
      "Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ",
      (jenis) => {
        const jenisLowerCase = jenis.toLowerCase();
        if (jenisLowerCase == "elektronik") {
          diskon = hargaAwal * 0.1;
          hargaAkhir = hargaAwal - diskon;
          console.log("Harga awal: " + hargaAwal);
          console.log("Diskon: 10%");
          console.log("Harga setelah diskon: " + hargaAkhir);
        } else if (jenisLowerCase == "pakaian") {
          diskon = hargaAwal * 0.2;
          hargaAkhir = hargaAwal - diskon;
          console.log("Harga awal: " + hargaAwal);
          console.log("Diskon: 20%");
          console.log("Harga setelah diskon: " + hargaAkhir);
        } else if (jenisLowerCase == "makanan") {
          diskon = hargaAwal * 0.05;
          hargaAkhir = hargaAwal - diskon;
          console.log("Harga awal: " + hargaAwal);
          console.log("Diskon: 5%");
          console.log("Harga setelah diskon: " + hargaAkhir);
        } else {
          console.log("Harga awal: " + hargaAwal);
          console.log("Diskon: Tidak ada diskon");
          console.log("Harga setelah diskon: " + hargaAkhir);
        }
        rl.close();
      }
    );
  }
});
