import { Queue } from '../structures.js'; 
 
const antrian = new Queue(); 
let nomorTerakhir = 0; 
 
const dipanggil = document.getElementById('dipanggil'); 
const jumlah = document.getElementById('jumlah'); 
const daftar = document.getElementById('daftar'); 
 
function formatNomor(angka) { 
  return 'A' + String(angka).padStart(3, '0'); 
} 
 
function tampilkanDaftar() { 
  daftar.textContent = ''; 
  for (let i = antrian.head; i < antrian.tail; i++) { 
    const li = document.createElement('li'); 
    li.textContent = antrian.items[i]; 
    daftar.append(li); 
  } 
  jumlah.textContent = antrian.size(); 
} 
 
document.getElementById('ambil').addEventListener('click', () => { 
  nomorTerakhir++; 
  antrian.enqueue(formatNomor(nomorTerakhir)); 
  tampilkanDaftar(); 
}); 
 
document.getElementById('panggil').addEventListener('click', () => { 
  dipanggil.textContent = antrian.isEmpty() ? 'Antrean kosong' : antrian.dequeue(); 
  tampilkanDaftar(); 
});