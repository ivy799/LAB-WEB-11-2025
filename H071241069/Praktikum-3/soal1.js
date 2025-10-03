function countEvenNumbers (start, end) {
  if (isNaN(start) || isNaN(end)) {
    console.log("Input harus angka");
    return;
  }
  
  let jumlahGenap = 0
  let genap = []

  for (let i = start; i <= end; i++) {
    if (i % 2 == 0) {
      jumlahGenap++
      genap.push(i)
    }
  }
  console.log(jumlahGenap, genap); 
}

countEvenNumbers(1,10)