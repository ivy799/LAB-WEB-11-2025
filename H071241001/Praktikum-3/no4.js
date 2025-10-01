const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const angkaRahasia = Math.floor(Math.random() * 100) + 1;
let jumlahTembakan = 0; 

console.log("Aku telah memilih sebuah angka antara 1 dan 100. Coba tebak!");

function mulaiTebak() {
    rl.question('Masukkan tebakanmu: ', (jawaban) => {
        const tebakan = parseInt(jawaban);

        if (isNaN(tebakan)) {
            console.log("Error: Harap masukkan angka. Coba lagi.");
            mulaiTebak();
            return;
        } else if (tebakan < 1 || tebakan > 100) {
            console.log("Error: Angka harus antara 1 dan 100. Coba lagi.");
            mulaiTebak();
            return;
        }
        
        if (tebakan > angkaRahasia) {
            console.log("Terlalu tinggi!");
            mulaiTebak();
            jumlahTembakan++;
            return;
        } else if (tebakan < angkaRahasia) {    
            console.log("Terlalu rendah!");
            mulaiTebak();
            jumlahTembakan++;
            return;
        } else {    
            console.log(`Selamat! Kamu menebak angka ${angkaRahasia} dengan benar dalam ${jumlahTembakan} percobaan.`);
            rl.close();
        }
    });      
}

mulaiTebak();
