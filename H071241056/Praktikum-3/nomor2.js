const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,   // ambil input dari terminal
  output: process.stdout  // tampilkan output ke terminal
});

let hargaDiskon;
let diskon = 'tidak ada';
const jenisBarang = ['elektronik', 'makanan', 'pakaian', 'lainnya'];
function hargaBarang(){
    rl.question('Harga barang: ', (hargaInput)=>{
        try {
            if(hargaInput.trim()===''){
                throw new Error ('Harga tidak boleh kosong');
            }
            const harga = Number(hargaInput);

            if (isNaN(harga)){
                throw new Error('Inputan harus berupa angka');
            }
            if (harga <= 0){
                throw new Error('Harga harus lebih besar dari 0');
            }
        
        rl.question('Jenis barang (Elektronik, pakaian, makanan, lainnya): ',(jenisInput)=>{
        try {
            if (jenisInput.trim() === ''){
                throw new Error('jenis barang tidak boleh kosong');
            }

            const jenis = jenisInput.toLowerCase().trim();

            if(!jenisBarang.includes(jenis)){
                throw new Error('jenis barang tidak valid');
            }
                
            if (jenis === 'elektronik'){
                hargaDiskon = harga - (harga*10/100);
                diskon = '10%';
            } else if (jenis === 'pakaian'){
                hargaDiskon = harga - (harga*20/100);
                diskon = '20%';
            } else if (jenis === 'makanan'){
                hargaDiskon = harga - (harga*5/100);
                diskon = '5%';
            } else {
                hargaDiskon = harga;
            }
            console.log('harga awal: Rp',harga);
            console.log('diskon: ',diskon);
            console.log('harga setelah diskon: Rp',hargaDiskon);
            rl.close();
    } catch(error){
        console.log(error.message);
        console.log('silahkan input ulang.\n');
        hargaBarang();
    }
    });
    } catch (error){
        console.log(error.message);
        console.log('silahkan input ulang.\n');
        hargaBarang();
        }
    });
}
hargaBarang();
