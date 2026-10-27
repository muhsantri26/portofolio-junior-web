/**
 * Tumpukan LIFO untuk menyimpan keadaan undo dan redo.
 */
export class Stack {
  #items = [];

  /**
   * Menambahkan item ke bagian atas tumpukan.
   * @param {*} item Item yang disimpan.
   */
  push(item) {
    this.#items.push(item);
  }

  /**
   * Mengambil dan menghapus item paling atas.
   * @returns {*|undefined} Item teratas atau undefined jika kosong.
   */
  pop() {
    return this.isEmpty() ? undefined : this.#items.pop();
  }

  /**
   * Membaca item paling atas tanpa menghapusnya.
   * @returns {*|undefined} Item teratas atau undefined jika kosong.
   */
  peek() {
    return this.isEmpty() ? undefined : this.#items[this.#items.length - 1];
  }

  /**
   * Memeriksa apakah tumpukan tidak memiliki item.
   * @returns {boolean} True jika tumpukan kosong.
   */
  isEmpty() {
    return this.#items.length === 0;
  }

  /**
   * Mengembalikan jumlah item di tumpukan.
   * @returns {number} Jumlah item.
   */
  size() {
    return this.#items.length;
  }

  /**
   * Mengembalikan salinan item dari bawah ke atas.
   * @returns {Array<*>} Salinan item tumpukan.
   */
  toArray() {
    return [...this.#items];
  }

  /**
   * Menghapus seluruh item dari tumpukan.
   */
  clear() {
    this.#items = [];
  }
}

class Node {
  constructor(data) {
    this.data = data;
    this.next = null;
  }
}

/**
 * Daftar berantai tunggal dengan akses kepala dan ekor.
 */
export class LinkedList {
  #head = null;
  #tail = null;
  #size = 0;

  /**
   * Menambahkan data baru di awal daftar.
   * @param {*} data Data yang ditambahkan.
   */
  addFirst(data) {
    const node = new Node(data);
    node.next = this.#head;
    this.#head = node;
    if (this.#tail === null) this.#tail = node;
    this.#size++;
  }

  /**
   * Menambahkan data baru di akhir daftar.
   * @param {*} data Data yang ditambahkan.
   */
  addLast(data) {
    const node = new Node(data);
    if (this.#tail === null) {
      this.#head = node;
    } else {
      this.#tail.next = node;
    }
    this.#tail = node;
    this.#size++;
  }

  /**
   * Menghapus dan mengembalikan data pertama.
   * @returns {*|undefined} Data pertama atau undefined jika daftar kosong.
   */
  removeFirst() {
    if (this.#head === null) return undefined;
    const data = this.#head.data;
    this.#head = this.#head.next;
    if (this.#head === null) this.#tail = null;
    this.#size--;
    return data;
  }

  /**
   * Membaca data pertama tanpa menghapusnya.
   * @returns {*|undefined} Data pertama atau undefined jika daftar kosong.
   */
  peekFirst() {
    return this.#head === null ? undefined : this.#head.data;
  }

  /**
   * Mencari data pertama yang memenuhi predikat.
   * @param {Function} predikat Fungsi yang menerima data dan mengembalikan boolean.
   * @returns {*|undefined} Data yang cocok atau undefined jika tidak ditemukan.
   */
  find(predikat) {
    let saatIni = this.#head;
    while (saatIni !== null) {
      if (predikat(saatIni.data)) return saatIni.data;
      saatIni = saatIni.next;
    }
    return undefined;
  }

  /**
   * Menghapus data pertama yang sama dengan nilai yang diberikan.
   * @param {*} data Nilai data yang akan dihapus.
   * @returns {*|undefined} Data yang dihapus atau undefined jika tidak ditemukan.
   */
  remove(data) {
    if (this.#head === null) return undefined;
    if (this.#head.data === data) {
      return this.removeFirst();
    }
    let saatIni = this.#head;
    while (saatIni.next !== null && saatIni.next.data !== data) {
      saatIni = saatIni.next;
    }
    if (saatIni.next === null) return undefined;

    const dataDihapus = saatIni.next.data;
    saatIni.next = saatIni.next.next;
    if (saatIni.next === null) this.#tail = saatIni;
    this.#size--;
    return dataDihapus;
  }

  /**
   * Mengembalikan jumlah data di daftar.
   * @returns {number} Jumlah data.
   */
  size() {
    return this.#size;
  }

  /**
   * Memeriksa apakah daftar kosong.
   * @returns {boolean} True jika daftar kosong.
   */
  isEmpty() {
    return this.#size === 0;
  }

  /**
   * Mengembalikan data sebagai array dari kepala ke ekor.
   * @returns {Array<*>} Salinan data dalam daftar.
   */
  toArray() {
    const hasil = [];
    let saatIni = this.#head;
    while (saatIni !== null) {
      hasil.push(saatIni.data);
      saatIni = saatIni.next;
    }
    return hasil;
  }
}

/**
 * Antrean FIFO berbasis linked list dengan operasi enqueue/dequeue O(1).
 */
export class LinkedQueue {
  #daftar = new LinkedList();

  /**
   * Menambahkan item ke belakang antrean.
   * @param {*} item Item yang ditambahkan.
   */
  enqueue(item) {
    this.#daftar.addLast(item);
  }

  /**
   * Mengambil dan menghapus item paling depan.
   * @returns {*|undefined} Item terdepan atau undefined jika antrean kosong.
   */
  dequeue() {
    return this.#daftar.removeFirst();
  }

  /**
   * Membaca item paling depan tanpa menghapusnya.
   * @returns {*|undefined} Item terdepan atau undefined jika antrean kosong.
   */
  front() {
    return this.#daftar.peekFirst();
  }

  /**
   * Memeriksa apakah antrean kosong.
   * @returns {boolean} True jika antrean kosong.
   */
  isEmpty() {
    return this.#daftar.isEmpty();
  }

  /**
   * Mengembalikan jumlah item yang menunggu.
   * @returns {number} Jumlah item.
   */
  size() {
    return this.#daftar.size();
  }

  /**
   * Mengembalikan salinan item dari depan ke belakang.
   * @returns {Array<*>} Item antrean sebagai array.
   */
  toArray() {
    return this.#daftar.toArray();
  }
}
