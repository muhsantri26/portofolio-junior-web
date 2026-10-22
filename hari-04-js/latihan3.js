// // Faktorial 
// const n = 5; 
// let faktorial = 1; 
// for (let i = 2; i <= n; i++) { 
//   faktorial *= i; 
// } 
// console.log(`${n}! = ${faktorial}`); 
 
// // Fibonacci 10 suku pertama 
// let a = 0; 
// let b = 1; 
// const hasil = []; 
// for (let i = 0; i < 10; i++) { 
//   hasil.push(a); 
//   [a, b] = [b, a + b]; 
// } 
// console.log(hasil.join(', ')); 
 
 
// // Bilangan prima sampai 50 
// for (let angka = 2; angka <= 50; angka++) { 
//   let prima = true; 
//   for (let pembagi = 2; pembagi * pembagi <= angka; pembagi++) { 
//     if (angka % pembagi === 0) { 
//       prima = false; 
//       break; 
//     } 
//   } 
//   if (prima) console.log(angka); 
// } 

// 1. Tabel perkalian 1 sampai 10 (perulangan bersarang)
// console.log('1. Tabel perkalian 1 sampai 10');
// for (let i = 1; i <= 10; i++) {
//   let baris = '';
//   for (let j = 1; j <= 10; j++) {
//     baris += (i * j) + '\t';
//   }
//   console.log(baris);
// }
// console.log('');

// 2. Pola segitiga bintang dan piramida; bentuk persegi angka
// console.log('2. Segitiga bintang');
// for (let i = 1; i <= 5; i++) {
//   let bintang = '';
//   for (let j = 1; j <= i; j++) {
//     bintang += '* ';
//   }
//   console.log(bintang);
// }

// console.log('\nPiramida');
// for (let i = 1; i <= 5; i++) {
//   let spasi = ' '.repeat(5 - i);
//   let bintang = '* '.repeat(i);
//   console.log(spasi + bintang);
// }

// console.log('\nPersegi angka');
// const ukuran = 5;
// for (let i = 1; i <= ukuran; i++) {
//   let baris = '';
//   for (let j = 1; j <= ukuran; j++) {
//     baris += (i * j) + ' ';
//   }
//   console.log(baris);
// }
// console.log('');

// 3. FizzBuzz 1-50
// console.log('3. FizzBuzz 1-50');
// for (let i = 1; i <= 50; i++) {
//   if (i % 3 === 0 && i % 5 === 0) {
//     console.log('FizzBuzz');
//   } else if (i % 3 === 0) {
//     console.log('Fizz');
//   } else if (i % 5 === 0) {
//     console.log('Buzz');
//   } else {
//     console.log(i);
//   }
// }
// console.log('');

// 4. Jumlah digit dari sebuah angka (misal 4821 menjadi 15) memakai while dan Math.floor
// console.log('4. Jumlah digit');
// let angka = 4821;
// let jumlahDigit = 0;
// while (angka > 0) {
//   jumlahDigit += angka % 10;
//   angka = Math.floor(angka / 10);
// }
// console.log(`Jumlah digit = ${jumlahDigit}`);
// console.log('');

// 5. Tebak angka: komputer memilih angka acak Math.floor(Math.random() * 100) + 1
let angka = Math.floor(Math.random() * 100) + 1;
let input;
do {
  input = parseInt(prompt('Tebak angka antara 1 dan 100:'));
    if (input < angka) {    
        console.log('Terlalu rendah! Coba lagi.');
    } else if (input > angka) {
        console.log('Terlalu tinggi! Coba lagi.');
    } else {
        console.log('Selamat! Anda menebak angka yang benar.');
    }
} while (angka !== input);



