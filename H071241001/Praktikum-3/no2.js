const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question('Masukkan harga barang: ', (hargaInput) => {
    rl.question('Masukkan jenis barang (elektronik, Pakaian, Makanan, Lainnya): ', (jenisInput) => {

    const harga = parseFloat(hargaInput);
    const jenis = jenisInput.trim().toLowerCase();

    if (isNaN(harga)){
        console.log("Error: Harga yang dimasukkan bukan angka");
        rl.close();
        return
    }

    let diskon = 0;

    switch (jenis){
        case 'elektronik':
            diskon = 0.10;
            break;
        case 'pakaian':
            diskon = 0.20;
            break;
        case 'makanan':
            diskon = 0.05;
            break;
        case 'lainnya':
            diskon = 0.0;
            break;
    }
    const hargaAkhir = harga - (harga * diskon);
    console.log(`Harga awal: Rp ${harga}`);
    console.log(`Diskon yang diberikan: ${diskon * 100}%`);
    console.log(`Harga setelah diskon: Rp ${hargaAkhir}`);
    rl.close();
    });
});