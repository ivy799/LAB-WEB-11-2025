function countEvenNumber(awal, akhir){
    let genap = [];
    let count = 0;
    if (isNaN(awal)){
        console.log('Masukkan angka')
    } else {
        for (i = awal;i <= akhir; i++){
            if (i % 2 === 0){
                genap.push(i);
                count++;
            }
        }console.log(count, genap);   
    }
}
countEvenNumber(1,10);
