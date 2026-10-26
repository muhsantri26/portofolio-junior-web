// hitung frekuensi kata dari kalimat 'saya belajar web saya suka web' memakai map
// const kalimat = 'saya belajar web saya suka web';
// const kataArray = kalimat.split(' ');
// const frekuensiMap = new Map();

// kataArray.forEach(kata => {
//     frekuensiMap.set(kata, (frekuensiMap.get(kata) || 0) + 1);
// });

// const frekuensiTerurut = [...frekuensiMap.entries()]
//     .sort((a, b) => b[1] - a[1])
//     .map(([kata, frekuensi]) => `${kata}: ${frekuensi}`);

// console.log('Frekuensi Kata Terurut:', frekuensiTerurut);

// jumlah kata sumua kata dalam kalimat
// const jumlahKata = kataArray.length;
// console.log('Jumlah Kata:', jumlahKata);

// menghilangkan duplikat dari daftar email memakai set tamplilkan sebelum dan sesudah
// const emails = ['user1@example.com', 'user2@example.com', 'user1@example.com', 'user3@example.com'];
// console.log('sebelum hilangkan duplikat:', emails);

// const emailsUnik = [...new Set(emails)];
// console.log('Setelah hilangkan Duplikat:', emailsUnik);

// cari irisan dua dadftar peserta (kelas A dan kelas B) memakai set
// const kelasA = new Set(['Alice', 'Bob', 'Charlie']);
// const kelasB = new Set(['Bob', 'David', 'Eve']);
// const irisan = [...kelasA].filter(x => kelasB.has(x));
// console.log('Irisan kelas A dan B:', irisan);

// Buat fungsi adaDuplikat(daftar) (versi Set) dan uji dengan array kosong, satu elemen, dan elemen berulang. 
function adaDuplikat(daftar) {
    return new Set(daftar).size !== daftar.length;
}

// uji fungsi adaDuplikat
console.log('array kosong:', adaDuplikat([])); // false
console.log('array satu elemen:', adaDuplikat(['Alice'])); // false
console.log('array beberapa elemen duplikat:', adaDuplikat(['Alice', 'Bob', 'Alice'])); // true