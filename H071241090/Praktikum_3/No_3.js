
const readline = require('readline');

// Create interface for input/output
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

rl.question('Masukkan hari : ', (inputHari) => {
    let hari = inputHari.toLowerCase()
    let hariList = ["senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"];
  
  // Ask follow-up question
  rl.question('Masukkan jumlah hari yang akan datang : ', (inputJumlah) => {
    let jumlah = parseInt(inputJumlah);
    let indexHari = hariList.indexOf(hari);

    if (indexHari == -1) {
        console.log("Hari tidak valid!")
    } else {
        try {
          let indexBaru = (indexHari + jumlah) % 7;
          let hariBaru = hariList[indexBaru];
          hariBaru = hariBaru.charAt(0).toUpperCase() + hariBaru.slice(1);

          console.log(`${jumlah} hari setelah ${hari} adalah: ${hariBaru}`);

        } 
        catch (err) {
          console.log("Input harus angka!!")
        }
    }
    rl.close();
  });
});