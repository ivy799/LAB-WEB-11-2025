const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const daftarHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

rl.question('Masukkan hari saat ini: ', (hariInput) => {
    rl.question('Masukkan jumlah hari yang akan datang: ', (jumlahHariInput) => {

        const hariAwal = hariInput.trim().toLowerCase();
        const jumlahHari = parseInt(jumlahHariInput);

        const indeksHariAwal = daftarHari.indexOf(hariAwal);

        if (indeksHariAwal === -1) {
            console.log("Error: Hari yang dimasukkan tidak valid");
            rl.close();
            return;
        } else if (isNaN(jumlahHari) || jumlahHari < 0) {
            console.log("Error: Jumlah hari yang dimasukkan bukan angka atau negatif");
            rl.close();
            return;
        }

        const indeksHariAkhir = (indeksHariAwal + jumlahHari) % 7;
        const hariAkhir = daftarHari[indeksHariAkhir];

        const outputHariAwal = hariAwal.charAt(0).toUpperCase() + hariAwal.slice(1);
        const outputHariAkhir = hariAkhir.charAt(0).toUpperCase() + hariAkhir.slice(1);
        console.log(`${jumlahHari} hari setelah hari ${outputHariAwal} adalah ${outputHariAkhir}`);
        rl.close();
    });
});