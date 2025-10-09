const readline = require('readline')

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout,
})

rl.question('masukkan harga barang: Rp ', (hargaInput) => {
    rl.question('masukkan jenis barang(Elektronik, Pakaian, Makanan, Lainnya): ',(jenisInput) =>{
        const harga = parseInt(hargaInput)
        const jenis = jenisInput.toLowerCase();

        if (isNaN(harga)) {
        console.log("Error: Harga yang dimasukkan harus berupa angka.");
        rl.close()
        return
        }

        let diskon=0

        switch (jenis){
        case 'elektronik':
            diskon = 0.10
            break
        case 'pakaian':
            diskon = 0.20
            break
        case 'makanan':
            diskon = 0.05
            break
        default:
            diskon = 0.0 
            break
         }

        const jumlahPotongan = harga * diskon
        const hargaDiskon =harga - jumlahPotongan

        console.log("Harga awal: Rp " + harga);
        console.log("Diskon: " + (diskon * 100) + "%");
        console.log("Harga setelah diskon: Rp " + hargaDiskon);
        rl.close()
    })
})