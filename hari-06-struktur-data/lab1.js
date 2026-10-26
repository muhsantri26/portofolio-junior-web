const peserta = [
  { id: 1, nama: "Sari", kelas: "Web", nilai: 90, aktif: true },
  { id: 2, nama: "Budi", kelas: "Web", nilai: 68, aktif: true },
  { id: 3, nama: "Citra", kelas: "Data", nilai: 82, aktif: false },
  { id: 4, nama: "Dewi", kelas: "Data", nilai: 75, aktif: true },
  { id: 5, nama: "Eko", kelas: "Web", nilai: 88, aktif: false },
  { id: 6, nama: "Fajar", kelas: "Data", nilai: 95, aktif: true },
];

// peserta yang aktif
// const pesertaAktif = peserta.filter((p) => p.aktif);
// console.log("Peserta Aktif:", pesertaAktif);

// urutkan berdasarkan nama (sort dengan localeCompare) tanpa mengubah aray asli
// const pesertaTerurut = [...peserta].sort((a, b) =>
//   a.nama.localeCompare(b.nama),
// );
// console.log("Peserta Terurut:", pesertaTerurut);

// cari perserta berdasarkan id (find) dan tangani bila tidak ditemukan
// const pesertaById = peserta.find((p) => p.id === 12);
// if (pesertaById) {
//   console.log("Peserta ditemukan:", pesertaById);
// } else {
//   console.log("Peserta  tidak ditemukan.");
// }

// hitung jumlah pserta per  kelas dengan object penghitung
// const jumlahPerKelas = peserta.reduce((acc, p) => {
//   acc[p.kelas] = (acc[p.kelas] || 0) + 1;
//   return acc;
// }, {});
// console.log("Jumlah Peserta per Kelas:", jumlahPerKelas);

// tambah, ubah, dan hapus peserta (push, perubahan properti, filter atau splice) lalu tampilkan hasilnya

// tambah peserta baru
// peserta.push({ id: 7, nama: "Gilang", kelas: "Web", nilai: 80, aktif: true });
// console.log("Setelah menambah peserta:", peserta);

// ubah properti peserta
// const pesertaToUpdate = peserta.find((p) => p.id === 2);
// if (pesertaToUpdate) {
//   pesertaToUpdate.nilai = 75;
// }
// console.log("Setelah mengubah peserta:", peserta);

// hapus peserta
// const pesertaToDelete = peserta.find((p) => p.id === 3);
// if (pesertaToDelete) {
//   const index = peserta.indexOf(pesertaToDelete);
//   peserta.splice(index, 1);
// }
// console.log("Setelah menghapus peserta:", peserta);

// ubah array menjadi objek berindeks id (reduce) sehingga pencarian berdasdar id menjadi lebih cepat
const pesertaObject = peserta.reduce((acc, p) => {
  acc[p.id] = p;
  return acc;
}, {});
console.log("Peserta dalam bentuk objek:", pesertaObject);