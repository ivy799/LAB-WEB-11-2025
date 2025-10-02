const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const angkaRahasia= Math.floor(Math.random() * 100) + 1
let jumlahTebakan = 0

function tanyaTebakan(){
    rl.question('Masukkan salah satu angka dari 1 sampai 100: ', (angkaInput)=>{
        const tebakan = parseInt(angkaInput)
        

        if (isNaN(tebakan)) {
            console.log("Input tidak valid. Harap masukkan angka.");
            tanyaTebakan();
            return;
        }

        if(angkaRahasia < tebakan){
            console.log('Terlalu tinggi!, coba lagi')
            jumlahTebakan++
            tanyaTebakan()

        }else if( angkaRahasia > tebakan){
            console.log('Terlalu rendah!, coba lagi')
            jumlahTebakan++
            tanyaTebakan()
        }else{
            console.log("Selamat! kamu berhasil menebak angka " + angkaRahasia + " dengan benar.");
            console.log("\nSebanyak " + jumlahTebakan + "x percobaan.");
            rl.close()
        }
    })
}

tanyaTebakan()