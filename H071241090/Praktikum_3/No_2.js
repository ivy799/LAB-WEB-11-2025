const readline = require('readline');

// Create interface for input/output
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

rl.question('Masukkan harga barang: ', (inputHarga) => {
  let harga = inputHarga;

  if (isNaN(harga)) {
    console.log("Input harga harus berupa angka!");
    rl.close();
    return;
  }
  
  // Ask follow-up question
  rl.question('Masukkan jenis barang (Elektronik, Pakaian, Makanan,Lainnya): ', (inputJenis) => {
    let jenis = inputJenis.toLowerCase();
    let diskon = 0;

  
      if (jenis == "elektronik") {
        diskon = 0.10;
    } else if (jenis == "pakaian") {
        diskon = 0.20;
    } else if (jenis == "makanan") {
        diskon = 0.05;
    } else {
    }

    let potongan = harga * diskon;
    let hargaAkhir = harga-potongan;

    console.log(`Harga awal: Rp ${harga}`);
    console.log(`Diskon: ${diskon * 100}%`);
    console.log(`Harga setelah diskon: Rp ${hargaAkhir}`);


    rl.close();
  });
});