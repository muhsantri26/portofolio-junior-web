// contoh penulisan kode yang tidak baik

var d = [80, 65, 90];
function f(a) {
  var s = 0;
  for (var i = 0; i < a.length; i++) {
    s = s + a[i];
  }
  return s / a.length;
}
function g(x) {
  if (x >= 85) {
    return "A";
  } else {
    if (x >= 70) {
      return "B";
    } else {
      if (x >= 55) {
        return;
        ("C");
      } else {
        return "D";
      }
    }
  }
}
var r = f(d);
if (r == 80) {
  console.log("bagus");
}
function h(n) {
  var p = n * 0.11;
  return n + p;
}
function k(n) {
  var p = n * 0.11;
  return n + p;
}
console.log(g(r));

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



