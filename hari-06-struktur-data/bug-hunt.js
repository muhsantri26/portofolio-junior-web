// Bug Hunt - Struktur Data
// File ini berisi contoh kode bermasalah yang sering ditemukan saat belajar queue, stack, array, dan pencarian.
// Tujuan: memahami gejala bug, lalu memperbaikinya.

console.log('=== Bug Hunt - Struktur Data ===');

// 1) Dequeue pada queue kosong dipakai sebagai angka
class QueueBuggy {
  constructor() {
    this.items = {};
    this.head = 0;
    this.tail = 0;
  }

  enqueue(item) {
    this.items[this.tail] = item;
    this.tail++;
  }

  dequeue() {
    // BUG: tidak mengecek queue kosong
    const item = this.items[this.head];
    delete this.items[this.head];
    this.head++;
    return item;
  }

  isEmpty() {
    return this.tail === this.head;
  }

  size() {
    return this.tail - this.head;
  }
}

const qKosong = new QueueBuggy();
const hasilDequeueKosong = qKosong.dequeue() + 1;
console.log('1) Dequeue pada queue kosong:', hasilDequeueKosong);
console.log('   Gejala: undefined + 1 = NaN');

// 2) Pop pada stack kosong dipakai tanpa pemeriksaan
class StackBuggy {
  constructor() {
    this.items = [];
  }

  push(item) {
    this.items.push(item);
  }

  pop() {
    // BUG: langsung pop tanpa cek kosong
    return this.items.pop();
  }

  peek() {
    return this.items[this.items.length];
  }
}

const stackKosong = new StackBuggy();
const hasilPopKosong = stackKosong.pop() + 1;
console.log('2) Pop pada stack kosong:', hasilPopKosong);
console.log('   Gejala: undefined + 1 = NaN');

// 3) Peek selalu undefined karena salah index
const stack = new StackBuggy();
stack.push('A');
stack.push('B');
console.log('3) Peek salah index:', stack.peek());
console.log('   Gejala: selalu undefined karena memakai items.length, bukan items.length - 1');

// 4) Queue.size() salah karena menghitung tail + head
class QueueSizeBuggy extends QueueBuggy {
  size() {
    // BUG: seharusnya tail - head
    return this.tail + this.head;
  }
}

const qUkur = new QueueSizeBuggy();
qUkur.enqueue('A');
qUkur.enqueue('B');
qUkur.enqueue('C');
console.log('4) Ukuran queue salah:', qUkur.size());
console.log('   Gejala: hasil lebih besar dari jumlah data yang sebenarnya');

// 5) Sort membuat array asli ikut berubah
const daftar = [4, 1, 3, 2];
const salinan = daftar;
salinan.sort((a, b) => a - b);
console.log('5) Sort tanpa cloning:', daftar);
console.log('   Gejala: array asli berubah karena salinan dan daftar mengacu ke referensi yang sama');

// 6) Pencarian di loop besar, kompleksitas menjad O(n^2)
function cariIdDenganLoop(data, target) {
  for (let i = 0; i < data.length; i++) {
    // BUG: find() dipanggil di dalam loop, sehingga kerja berulang terus menerus.
    const ditemukan = data.find(item => item.id === target);
    if (ditemukan) return ditemukan;
  }
  return null;
}

const dataPeserta = Array.from({ length: 2000 }, (_, index) => ({
  id: index + 1,
  nama: `Peserta ${index + 1}`,
}));

console.time('6) Pencarian dengan loop + find');
const hasilCari = cariIdDenganLoop(dataPeserta, 1500);
console.timeEnd('6) Pencarian dengan loop + find');
console.log('6) Hasil pencarian:', hasilCari ? hasilCari.nama : 'Tidak ditemukan');
console.log('   Gejala: lambat karena proses pencarian diulang berkali-kali');

// --- Versi yang benar (untuk pembelajaran) ---
console.log('\n=== Versi Benar (Fix) ===');

class QueueFix {
  constructor() {
    this.items = {};
    this.head = 0;
    this.tail = 0;
  }

  enqueue(item) {
    this.items[this.tail] = item;
    this.tail++;
  }

  dequeue() {
    if (this.isEmpty()) return undefined;
    const item = this.items[this.head];
    delete this.items[this.head];
    this.head++;
    return item;
  }

  isEmpty() {
    return this.tail === this.head;
  }

  size() {
    return this.tail - this.head;
  }
}

class StackFix {
  constructor() {
    this.items = [];
  }

  push(item) {
    this.items.push(item);
  }

  pop() {
    if (this.isEmpty()) return undefined;
    return this.items.pop();
  }

  peek() {
    if (this.isEmpty()) return undefined;
    return this.items[this.items.length - 1];
  }

  isEmpty() {
    return this.items.length === 0;
  }
}

const queueFix = new QueueFix();
queueFix.enqueue(10);
queueFix.enqueue(20);
console.log('Queue benar:', queueFix.dequeue(), 'sisa ukuran:', queueFix.size());

const stackFix = new StackFix();
stackFix.push('X');
stackFix.push('Y');
console.log('Stack benar:', stackFix.peek(), 'pop:', stackFix.pop());

const daftarAsli = [4, 1, 3, 2];
const daftarUrut = [...daftarAsli].sort((a, b) => a - b);
console.log('Sort aman:', daftarAsli, '->', daftarUrut);

const mapPeserta = new Map(dataPeserta.map(item => [item.id, item]));
console.log('Pencarian cepat:', mapPeserta.get(1500)?.nama);
