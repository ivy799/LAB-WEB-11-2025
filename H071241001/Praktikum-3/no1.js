function hitung (start, end){
   let simpan = [];

   if (isNaN(start, end)){
      console.log("Error. Parameter bukan angka")
   }else{
      for(let i = start; i <= end; i++){
         if (i % 2 == 0){
            simpan.push(i)
         }
      }
      console.log(`${simpan.length} [${simpan.join(',')}]`);
   }
}
hitung(12, 90);