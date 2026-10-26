import { Queue } from "./structures.js";

// uji dengan endqueue tiga elemen, dequeue hingga kosong, dan dequeue pada queue kosong
const queue = new Queue();
queue.enqueue(1);
queue.enqueue(2);
queue.enqueue(3);
// deque
console.log(queue.dequeue());
console.log(queue.dequeue());
console.log(queue.dequeue());

// dequeue pada queue kosong
console.log(queue.dequeue());
