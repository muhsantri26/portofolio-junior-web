import { hitung } from './operasi.js'; 
 
const layarEl = document.getElementById('layar'); 
const papan = document.getElementById('papan'); 
 
let layar = '0'; 
let angkaPertama = null; 
let operator = null; 
let siapReset = false; 
 
function perbaruiLayar() { 
layarEl.textContent = layar; 
} 
function masukkanAngka(digit) { 
if (digit === '.' && layar.includes('.') && !siapReset) return; 
if (layar === '0' && digit !== '.') { 
layar = digit; 
} else if (siapReset) { 
layar = digit === '.' ? '0.' : digit; 
siapReset = false; 
} else { 
layar += digit; 
} 
} 
function hitungHasil() { 
if (operator === null) return; 
try { 
const hasil = hitung(operator, angkaPertama, Number(layar)); 
layar = String(Number(hasil.toFixed(10))); 
} catch (error) { 
layar = error.message; 
} 
operator = null; 
angkaPertama = null; 
siapReset = true; 
} 
function pilihOperator(op) { 
if (operator !== null && !siapReset) hitungHasil(); 
angkaPertama = Number(layar); 
operator = op; 
siapReset = true; 
} 
function bersihkan() { 
layar = '0'; 
angkaPertama = null; 
operator = null; 
siapReset = false; 
} 
papan.addEventListener('click', (event) => { 
const tombol = event.target.closest('button'); 
if (!tombol) return; 
if (tombol.dataset.angka !== undefined) masukkanAngka(tombol.dataset.angka); 
else if (tombol.dataset.operator) pilihOperator(tombol.dataset.operator); 
else if (tombol.dataset.aksi === 'sama') hitungHasil(); 
else if (tombol.dataset.aksi === 'hapus') bersihkan(); 
perbaruiLayar(); 
}); 
