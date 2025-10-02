/*
Buatlah sebuah fungsi `countEvenNumbers` yang menerima parameter dua angka yakni, `start` dan `end`. 
Dari fungsi tersebut hitunglah berapa banyak bilangan genap yang ada dalam interval tersebut, termasuk 
`start` dan `end` jika mereka genap. 
*/

function hitung(start, end){
    
    let simpan = [];
    for (let i = start; i <= end; i++){
        if (i % 2 === 0)
            simpan.push(i);
        
    }
return(`${simpan.length}[${simpan.join(", ")}]`)
}

console.log (hitung(1, 10));