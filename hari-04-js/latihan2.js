
// const nilai = 90; 
// let grade; 
// if (nilai >= 85) grade = 'A'; 
// else if (nilai >= 70) grade = 'B'; 
// else if (nilai >= 55) grade = 'C'; 
// else grade = 'D'; 
// console.log(`Grade: ${grade}`); 
 
// // Program B: tahun kabisat 
// const tahun = 2002; 
// const kabisat = (tahun % 4 === 0 && tahun % 100 !== 0) || tahun % 400 === 0; 
// console.log(kabisat ? 'Kabisat' : 'Bukan kabisat');

// program penentuan ganjil genap
// const angka = 7;
// if (angka > 0) {
//     console.log("Positif");
// } else if (angka < 0) {
//     console.log ("Negatif");
// } else {
//     console.log("Nol");
// }

// if (angka % 2 == 0) {
//     console.log("Genap");
// } else {
//     console.log("Ganjil");
// }

// program tarif parkir
// const jam = 5;
// let tarif;

// if (jam <= 2) {
//     tarif = 3000;
// } else {
//     tarif = 3000 + ((jam - 2) * 2000);
// }

// if (tarif > 15000) {
//     tarif = 15000;
// }
// console.log("Tarif Parkir: Rp" + tarif);

// program kalkulator sederhana
// let nilai1, nilai2, operator, hasil;
// nilai1 = 10;
// nilai2 = 500;
// operator = "+";

// switch (operator) {

//     case "+":
//         hasil = nilai1 + nilai2;
//         console.log("Hasil: " + hasil);
//         break;

//     case "-":
//         hasil = nilai1 - nilai2;
//         console.log("Hasil: " + hasil);
//         break;

//     case "*":
//         hasil = nilai1 * nilai2;
//         console.log("Hasil: " + hasil);
//         break;

//     case "/":
//         if (nilai2 === 0) {
//             console.log("Error: Tidak bisa dibagi nol");
//         } else {
//             hasil = nilai1 / nilai2;
//             console.log("Hasil: " + hasil);
//         }
//         break;

//     default:
//         console.log("Operator tidak valid");
// }

// program penentu bmi 

let berat, tinggi, bmi, keteragan;
berat = 170; // dalam kilogram
tinggi = 1.75; // dalam meter

bmi = berat / (tinggi * tinggi);

if (bmi < 18.5) {
    keteragan = "Kurang";
} else if (bmi < 25) {
    keteragan = "Normal";
} else if (bmi < 30) {
    keteragan = "Lebih";
} else {
    keteragan = "Obesitas";
}

console.log("Keteragan: " + keteragan);

