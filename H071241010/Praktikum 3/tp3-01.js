function countEvenNumber(start, end){
    let evenNumber=[]
    let count = 0
    
    if (isNaN(start)||isNaN(end)){
        console.log("Masukkan angka")
        return
    } else if(start > end){
        console.log("masukkkan start lebih besar dari end")
        return
    }

    for (i = start; i <= end; i++ ){
        if(i % 2 == 0){
            evenNumber.push(i)
            count++
        }
    }
    console.log(count + "[" +evenNumber + "]")
}

countEvenNumber(1,10)