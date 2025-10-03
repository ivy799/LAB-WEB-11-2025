const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

const hariArray = [
  "senin",
  "selasa",
  "rabu",
  "kamis",
  "jumat",
  "sabtu",
  "minggu",
];

function hariSetelah(hari, jumlah) {
  const indexHari = hariArray.indexOf(hari.toLowerCase());
  const hasilIndex = (indexHari + (jumlah % 7)) % 7;
  return hariArray[hasilIndex];
}

rl.question("Masukkan hari: ", (hari) => {
  if (hari === hariArray) {
    rl.question("Masukkan jumlah hari yang akan datang: ", (jumlahHari) => {
      if (isNaN(jumlahHari)) {
        const hasil = hariSetelah(hari, parseInt(jumlahHari));
        console.log(`${jumlahHari} hari setelah ${hari} adalah ${hasil}`);
        rl.close();
      } else {
        console.log("Input tidak valid");
        rl.close();
      }
    });
  } else {
    console.log("Input tidak valid");
    rl.close();
  }
});
