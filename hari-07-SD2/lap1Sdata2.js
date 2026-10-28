// Uji LinkedList: addFirst, addLast, removeFirst, find, toArray, serta kasus kosong dan satu elemen.
import { LinkedList, Queue, LinkedQueue } from './structures.js';

const linkedList = new LinkedList();

// uji kasus kosong
// console.log("kasus kosong");
// console.log("Size:", linkedList.size());
// console.log("Is Empty:", linkedList.isEmpty());

// uji addFirst dan addLast
// linkedList.addFirst(1);
// linkedList.addLast(2);
// linkedList.addFirst(0);
// console.log("\nsetelat addFirst dan addLast:");
// console.log("Array:", linkedList.toArray());
// console.log("Size:", linkedList.size());
// console.log("Is Empty", linkedList.isEmpty());

// uji removeFirst
// const removed = linkedList.removeFirst();
// console.log("\nSetelah RemoveFirst");
// console.log("Elemen yang di hapus:", removed);
// console.log("Array:", linkedList.toArray());
// console.log("Size:", linkedList.size());

// uji find
// const found = linkedList.find((x) => x === 2);
// console.log("\nMencari elemen 2:");
// console.log("Elemen ditemukan:", found);

// Tambahkan method remove(data) yang menghapus node pertama bernilai data (tangani kasus kepala, tengah, ekor, dan tidak ada). Gambar dahulu pointer yang diubah.
// linkedList.remove(1);
// console.log("\nSetelah remove");
// console.log("Array:", linkedList.toArray());
// console.log("Size:", linkedList.size());

// Bandingkan kecepatan Queue array (versi shift) dengan LinkedQueue untuk 100.000 elemen
// memakai console.time, catat pada tabel.
const QueueArray = new Queue();
const linkedQueue = new LinkedQueue();
const numElements = 100000;
for (let i = 0; i < numElements; i++) {
  QueueArray.enqueue(i);
  linkedQueue.enqueue(i);
}
console.time('Queue Array Dequeue');
for (let i = 0; i < numElements; i++) {
  QueueArray.dequeue();
}
console.timeEnd('Queue Array Dequeue');

console.time('LinkedQueue Dequeue');
for (let i = 0; i < numElements; i++) {
  linkedQueue.dequeue();
}
console.timeEnd('LinkedQueue Dequeue');
