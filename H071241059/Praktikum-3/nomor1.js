function countEvenNumbers (start, end) {
  if (isNaN(start) || isNaN(end)) {
    console.log("Input harus angka");
    return
  }

  let evenNumber = []

  for (let i = start; i <= end; i++) {
    if (i % 2 == 0) {
      evenNumber.push(i)
    }
  }
  console.log(`${evenNumber.length} [${evenNumber.join(",")}]`)
}

countEvenNumbers(1,10)