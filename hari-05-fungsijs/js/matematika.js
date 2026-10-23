export function hitungRataRata(daftar) {
  if (!Array.isArray(daftar) || daftar.length === 0) return 0;

  const total = daftar.reduce((jumlah, nilai) => jumlah + Number(nilai), 0);
  return total / daftar.length;
}

export function cariTertinggi(daftar) {
  if (!Array.isArray(daftar) || daftar.length === 0) return null;

  return Math.max(...daftar.map(Number));
}

export function cariTerendah(daftar) {
  if (!Array.isArray(daftar) || daftar.length === 0) return null;

  return Math.min(...daftar.map(Number));
}