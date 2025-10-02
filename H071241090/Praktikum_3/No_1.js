
function countEvenNumbers (start, end) {

    if (typeof start === "number" && typeof end === "number" ){
        let evenList = [];
        let count = 0;

        for (i = start+1; i < end+1; i++) {
            if (i%2 != 0) {
                evenList.push(i);
                count += 1;
            }
        }
        console.log(count, evenList)
    } else {
        console.log("input harus angka")
        return 

    }
}

countEvenNumbers(1,10);