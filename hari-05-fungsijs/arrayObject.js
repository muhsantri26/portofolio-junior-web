const peserta = [
  { id: 1, nama: "Sari", kelas: "Web", nilai: 90 },
  { id: 2, nama: "Budi", kelas: "Web", nilai: 68 },
  { id: 3, nama: "Citra", kelas: "Data", nilai: 82 },
  { id: 4, nama: "Dewi", kelas: "Data", nilai: 75 },
  { id: 5, nama: "Eko", kelas: "Web", nilai: 95 },
  { id: 6, nama: "Fajar", kelas: "Data", nilai: 60 },
  { id: 7, nama: "Gita", kelas: "Web", nilai: 88 },
  { id: 8, nama: "Hadi", kelas: "Data", nilai: 70 },
];
const namaWeb = peserta.filter((p) => p.kelas === "Web").map((p) => p.nama);
const rata = peserta.reduce((j, p) => j + p.nilai, 0) / peserta.length;
const budi = peserta.find((p) => p.nama === "Budi");
const urutNilai = [...peserta].sort((a, b) => b.nilai - a.nilai);

// Menghitung jumlah per kelas
const perKelas = {};
for (const p of peserta) {
  perKelas[p.kelas] = (perKelas[p.kelas] || 0) + 1;
}

// daftar nama peserta yang lulus filter dan map
const pesertaLulus = peserta.filter((p) => p.nilai >= 70).map((p) => p.nama);
console.log("daftar nama peserta yang lulus:", pesertaLulus);

// rata-rata nilai per kelas
const rataWeb =
  peserta.filter((p) => p.kelas === "Web").reduce((j, p) => j + p.nilai, 0) /
  peserta.filter((p) => p.kelas === "Web").length;
const rataData =
  peserta.filter((p) => p.kelas === "Data").reduce((j, p) => j + p.nilai, 0) /
  peserta.filter((p) => p.kelas === "Data").length;
console.log("rata-rata nilai per kelas Web:", rataWeb);
console.log("rata-rata nilai per kelas Data:", rataData);

// Peserta dengan nilai tertinggi (reduce atau sort).
const pesertaTertinggi = peserta.reduce(
  (max, p) => (p.nilai > max.nilai ? p : max),
  peserta[0],
);
console.log("Peserta dengan nilai tertinggi:", pesertaTertinggi);

// Pencarian peserta berdasarkan sebagian nama (filter dan includes, tidak peka huruf besar-kecil)
const cariNama = (nama) =>
  peserta.filter((p) => p.nama.toLowerCase().includes(nama.toLowerCase()));
console.log("Pencarian peserta dengan nama mengandung 'di':", cariNama("di"));

// Daftar peringkat (sort pada salinan array) dengan nomor urut.
const pesertaPeringkat = [...peserta]
  .sort((a, b) => b.nilai - a.nilai)
  .map((p, index) => ({ peringkat: index + 1, nama: p.nama, nilai: p.nilai }));
console.log("Daftar peringkat peserta:", pesertaPeringkat);
