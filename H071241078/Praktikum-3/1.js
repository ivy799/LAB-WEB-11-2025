function countEvenNumbers(start, end) {
    if (typeof start !== "number" || typeof end !== "number") {
        throw new Error("Input harus berupa angka!");
    }
    let evenNumbers = [];
    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) evenNumbers.push(i);
    }
    console.log(`Jumlah bilangan genap: ${evenNumbers.length} [${evenNumbers.join(", ")}]`);
    return evenNumbers.length;
}
countEvenNumbers(1, 10);