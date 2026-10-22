// let nama = "Muhsan";
// let umur = 20;
// let tinggiBadan = 1.68;
// let statusAktif = true;

// console.log(`Nama: ${nama} Umur: ${umur}`);
// console.log(`Tinggi Badan: ${tinggiBadan} Status Aktif: ${statusAktif}`);

// console.log(typeof ("5" + 3)); // string
// console.log(typeof (0.1 + 0.2)); // number
// console.log(typeof Number("abc")); // number
// console.log(typeof (10 / 3)); // number
// console.log(typeof (10 % 3)); // number
// console.log(typeof 2); // number
// console.log(typeof (2 ** 10)); // number

// Menghitung luas dan keliling lingkaran
// let jari = 10;
// let luasLingkaran = Math.PI * jari ** 2;
// console.log(`Luas lingkaran dengan jari-jari ${jari} adalah ${luasLingkaran}`);
// let kelilingLingkaran = 2 * Math.PI * jari;
// console.log(`Keliling lingkaran dengan jari-jari ${jari} adalah ${kelilingLingkaran}`);

// program menghitung detik dalam sat hari
// let detikPerHari = 24 * 60 * 60;
// console.log(`Jumlah detik dalam satu hari adalah ${detikPerHari} detik`);

// program konversi suhu dari celcius ke fahrenheit
// let celcius = 30;
// let fahrenheit = (celcius * 9) / 5 + 32;
// console.log(`${celcius} derajat celcius sama dengan ${fahrenheit} derajat fahrenheit`);

const nilai = 90; 
let grade; 
if (nilai >= 85) grade = 'A'; 
else if (nilai >= 70) grade = 'B'; 
else if (nilai >= 55) grade = 'C'; 
else grade = 'D'; 
console.log(`Grade: ${grade}`); 
 
// Program B: tahun kabisat 
const tahun = 2002; 
const kabisat = (tahun % 4 === 0 && tahun % 100 !== 0) || tahun % 400 === 0; 
console.log(kabisat ? 'Kabisat' : 'Bukan kabisat');