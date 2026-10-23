export function validasiNama(nilai) { 
  return nilai.trim().length >= 3 ? '' : 'Nama minimal 3 karakter.'; 
} 
 
export function validasiEmail(nilai) { 
  const pola = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 
  return pola.test(nilai) ? '' : 'Format email tidak valid.'; 
} 
 
export function validasiHp(nilai) { 
  return /^08[0-9]{8,11}$/.test(nilai) ? '' : 'Nomor HP diawali 08 dan 10-13 digit.'; 
} 
 
export function validasiSandi(nilai) { 
  const kuat = nilai.length >= 8 && /[0-9]/.test(nilai) && /[A-Za-z]/.test(nilai); 
  return kuat ? '' : 'Sandi minimal 8 karakter, kombinasi huruf dan angka.'; 
} 
 
export function validasiKonfirmasi(nilai, sandi) { 
  return nilai === sandi ? '' : 'Konfirmasi sandi tidak cocok.'; 
} 