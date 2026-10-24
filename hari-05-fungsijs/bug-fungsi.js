function buatPesan(nama) {
  const pesan = `Halo, ${nama}!`;
  return pesan;
}

const pesan = buatPesan('Ayu');
console.log('Pesan:', pesan);

function hitungRataRata(daftar) {
  if (!Array.isArray(daftar) || daftar.length === 0) {
    return 0;
  }

  const total = daftar.reduce((jumlah, nilai) => jumlah + nilai, 0);
  return total / daftar.length;
}

console.log('Rata-rata:', hitungRataRata([]));
console.log('Rata-rata nilai:', hitungRataRata([80, 90, 75]));

const daftarAngka = [10, 2, 5];
daftarAngka.sort((a, b) => a - b);
console.log('Urutan angka:', daftarAngka);
