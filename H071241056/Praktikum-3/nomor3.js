const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,   // ambil input dari terminal
  output: process.stdout  // tampilkan output ke terminal
});

let hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

function tanyaHari() {
  rl.question('Masukkan hari: ', (hariSekarang) => {
    try {
      if (hariSekarang.trim() === '') {
        throw new Error('Inputan tidak boleh kosong');
      }

      let hariValid = hariSekarang.toLowerCase().trim();

      if (!hari.includes(hariValid)) {
        throw new Error('Hari yang diinput tidak valid');
      }

      rl.question('Masukkan jumlah hari yang akan datang: ', (hariDatang) => {
        try {
          if (hariDatang.trim() === '') {
            throw new Error('Inputan tidak boleh kosong');
          }
          if (isNaN(hariDatang)) {
            throw new Error('Inputan harus berupa angka');
          }

          let hariYangDatang = Number(hariDatang);
          let indexHari = hari.indexOf(hariValid); 

          let hasil = (indexHari + hariYangDatang) % hari.length;

          console.log(`${hariDatang} setelah hari ${hariSekarang} adalah ${hari[hasil]}`);
          

          rl.close();
        } catch (error) {
          console.log(error.message);
          console.log('Silahkan input ulang.\n');
          tanyaHari(); 
        }
      });

    } catch (error) {
      console.log(error.message);
      console.log('Silahkan input ulang.\n');
      tanyaHari(); 
    }
  });
}

tanyaHari();