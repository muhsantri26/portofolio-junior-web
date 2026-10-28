import { LinkedQueue } from './structures.js';

export const AWALAN_NOMOR = 'A';
export const MAKS_RIWAYAT = 50;
const JUMLAH_RIWAYAT_PANGGILAN = 5;

export class AntrianKlinik {
  #antrian = new LinkedQueue();
  #nomorTerakhir = 0;
  #riwayatDipanggil = [];

  ambilNomor() {
    this.#nomorTerakhir++;
    const nomor = `${AWALAN_NOMOR}${String(this.#nomorTerakhir).padStart(3, '0')}`;
    this.#antrian.enqueue(nomor);
    return nomor;
  }

  panggilBerikutnya() {
    if (this.#antrian.isEmpty()) return undefined;

    const nomor = this.#antrian.dequeue();
    this.#riwayatDipanggil.unshift(nomor);
    this.#riwayatDipanggil.length = Math.min(
      this.#riwayatDipanggil.length,
      JUMLAH_RIWAYAT_PANGGILAN,
    );
    return nomor;
  }

  reset() {
    this.#antrian = new LinkedQueue();
    this.#nomorTerakhir = 0;
    this.#riwayatDipanggil = [];
  }

  getDaftarMenunggu() {
    return this.#antrian.toArray();
  }

  getJumlahMenunggu() {
    return this.#antrian.size();
  }

  getRiwayatDipanggil() {
    return [...this.#riwayatDipanggil];
  }
}
