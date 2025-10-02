const readline = require('readline');
const hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question('Masukkan hari: ', (hariInput)=>{
    rl.question('Masukkan hari yang akan datang: ', (jumlahHariInput)=> {
        const hariIni = hariInput.toLowerCase()
        const jumlahHari = parseInt(jumlahHariInput)

        const indexHariini = hari.indexOf(hariIni)

        if (indexHariini === -1){
            console.log('Nama hari tidak valid')
            rl.close()
            return
        }

        const indexHariNanti = (indexHariini +jumlahHari) %7

        const hasil = hari[indexHariNanti]

        console.log("Output : " + jumlahHari + " hari setelah " + hariIni + " adalah " + hasil);
        
        rl.close()
    })
    
})