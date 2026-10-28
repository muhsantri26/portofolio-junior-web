// buat versi baik

const PAJAK = 0.11;
const BATAS_GRADE = { A: 85, B: 70, C: 55 };

// fungsi untuk menghitung nilai rata rata
function hitungRataRata(daftarNilai) {
  if (daftarNilai.length === 0) return 0;
  const jumlah = daftarNilai.reduce((total, nilai) => total + nilai, 0);
  return jumlah / daftarNilai.length;
}

// fungsi untuk menentukan grade berdasarkan nilai rata rata
function tentukanGrade(nilai) {
  if (nilai >= BATAS_GRADE.A) return 'A';
  if (nilai >= BATAS_GRADE.B) return 'B';
  if (nilai >= BATAS_GRADE.C) return 'C';
  return 'D';
}

// fungsi untuk menghitung harga pajak
function hitungHargaDenganPajak(harga) {
  return harga * (1 + PAJAK);
}
