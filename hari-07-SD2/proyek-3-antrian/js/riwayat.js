import { Stack } from './structures.js';
import { MAKS_RIWAYAT } from './antrian.js';

export class RiwayatEditor {
  #undoStack = new Stack();
  #redoStack = new Stack();
  #teksSaatIni;

  constructor(teksAwal = '') {
    this.#teksSaatIni = teksAwal;
  }

  catatPerubahan(teksBaru) {
    if (teksBaru === this.#teksSaatIni) return;

    this.#undoStack.push(this.#teksSaatIni);
    this.#batasiRiwayat(this.#undoStack);
    this.#redoStack.clear();
    this.#teksSaatIni = teksBaru;
  }

  undo() {
    if (this.#undoStack.isEmpty()) return undefined;

    this.#redoStack.push(this.#teksSaatIni);
    this.#teksSaatIni = this.#undoStack.pop();
    return this.#teksSaatIni;
  }

  redo() {
    if (this.#redoStack.isEmpty()) return undefined;

    this.#undoStack.push(this.#teksSaatIni);
    this.#batasiRiwayat(this.#undoStack);
    this.#teksSaatIni = this.#redoStack.pop();
    return this.#teksSaatIni;
  }

  bisaUndo() {
    return !this.#undoStack.isEmpty();
  }

  bisaRedo() {
    return !this.#redoStack.isEmpty();
  }

  getJumlahRiwayat() {
    return this.#undoStack.size();
  }

  #batasiRiwayat(stack) {
    if (stack.size() <= MAKS_RIWAYAT) return;

    const langkahTerbaru = stack.toArray().slice(-MAKS_RIWAYAT);
    stack.clear();
    langkahTerbaru.forEach((langkah) => stack.push(langkah));
  }
}
