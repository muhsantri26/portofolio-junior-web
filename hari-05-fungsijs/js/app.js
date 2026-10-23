import {
  hitungRataRata,
  cariTertinggi,
  cariTerendah,
} from './matematika.js';

const inputNilai = document.getElementById('nilai');
const tombolHitung = document.getElementById('hitung');
const hasil = document.getElementById('hasil');

function tampilkanHasil(nilai) {
  const angka = nilai
    .split(',')
    .map((item) => item.trim())
    .filter((item) => item !== '')
    .map((item) => Number(item));

  if (angka.length === 0 || angka.some((item) => Number.isNaN(item))) {
    hasil.innerHTML = '<p>Masukkan nilai dengan format angka, contoh: 80, 90, 75</p>';
    return;
  }

  const rataRata = hitungRataRata(angka);
  const nilaiTertinggi = cariTertinggi(angka);
  const nilaiTerendah = cariTerendah(angka);

  hasil.innerHTML = `
    <p>Rata-rata: ${rataRata}</p>
    <p>Nilai tertinggi: ${nilaiTertinggi}</p>
    <p>Nilai terendah: ${nilaiTerendah}</p>
  `;
}

tombolHitung.addEventListener('click', () => {
  tampilkanHasil(inputNilai.value);
});

tampilkanHasil(inputNilai.value);