const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,   // ambil input dari terminal
  output: process.stdout  // tampilkan output ke terminal
});

let angkaRandom = Math.floor(Math.random()*100)+1;
let tebakan = 1;
function tebakAngka(){
    rl.question('Masukkan angka 1-100: ',(angka)=>{
        try {
            if (isNaN(angka)){
                throw new Error ('Masukkan inputan angka');
            }
            angka = Number(angka);

            if (angka > 100|| angka < 0){
                throw new Error('input dalam rentan 1-100 saja');
            }
            if(angka > angkaRandom){
                console.log('terlalu tinggi, coba lagi!');
                tebakan++;
                tebakAngka();
            } else if (angka < angkaRandom){
                console.log('terlalu rendah, coba lagi!');
                tebakan++;
                tebakAngka();
            } else {
                console.log(`Selamat! kamu berhasil menebak angka ${angkaRandom} dengan benar`);
                console.log(`Sebanyak ${tebakan}x percobaan`)
                rl.close();
            }
        } catch(error) {
            console.log(error.message);
            console.log('silahkan input ulang.\n');
            tebakAngka();
        }
    })
}
tebakAngka();