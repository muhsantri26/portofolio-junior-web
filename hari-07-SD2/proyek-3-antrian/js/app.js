import { AntrianKlinik } from './antrian.js';
import { RiwayatEditor } from './riwayat.js';

const KUNCI_CATATAN = 'proyek-3-antrian-catatan';

function ambilElemen(id) {
  const elemen = document.getElementById(id);
  if (!elemen) {
    throw new Error(`Elemen dengan id "${id}" tidak ditemukan.`);
  }
  return elemen;
}

const antrian = new AntrianKlinik();
const nomorDipanggil = ambilElemen('nomor-dipanggil');
const pesanPanggilan = ambilElemen('pesan-panggilan');
const jumlahAntrean = ambilElemen('jumlah-antrean');
const labelJumlahAntrean = ambilElemen('label-jumlah-antrean');
const daftarAntrean = ambilElemen('daftar-antrean');
const antreanKosong = ambilElemen('antrean-kosong');
const riwayatPanggilan = ambilElemen('riwayat-panggilan');
const riwayatKosong = ambilElemen('riwayat-kosong');
const catatan = ambilElemen('catatan');
const tombolUndo = ambilElemen('undo');
const tombolRedo = ambilElemen('redo');
const jumlahRiwayat = ambilElemen('jumlah-riwayat');
const pesanPenyimpanan = ambilElemen('pesan-penyimpanan');
const catatanAwal = muatCatatan();
const editor = new RiwayatEditor(catatanAwal);

function muatCatatan() {
  try {
    return window.localStorage.getItem(KUNCI_CATATAN) ?? '';
  } catch (error) {
    tampilkanPesanPenyimpanan(
      `Catatan tersimpan untuk sesi ini saja: ${pesanError(error)}`,
      true,
    );
    return '';
  }
}

function pesanError(error) {
  return error instanceof Error
    ? error.message
    : 'penyimpanan browser tidak tersedia';
}

function tampilkanPesanPenyimpanan(pesan, gagal = false) {
  pesanPenyimpanan.textContent = pesan;
  pesanPenyimpanan.classList.toggle('is-error', gagal);
}

function simpanCatatan() {
  try {
    window.localStorage.setItem(KUNCI_CATATAN, catatan.value);
    tampilkanPesanPenyimpanan('Catatan tersimpan otomatis di perangkat ini.');
  } catch (error) {
    tampilkanPesanPenyimpanan(
      `Catatan belum tersimpan di perangkat: ${pesanError(error)}`,
      true,
    );
  }
}

function tampilkanAntrean() {
  const daftar = antrian.getDaftarMenunggu();
  jumlahAntrean.textContent = String(daftar.length);
  labelJumlahAntrean.textContent = `${daftar.length} nomor`;
  daftarAntrean.replaceChildren(
    ...daftar.map((nomor) => {
      const item = document.createElement('li');
      item.textContent = nomor;
      return item;
    }),
  );
  antreanKosong.hidden = daftar.length > 0;
  daftarAntrean.hidden = daftar.length === 0;
}

function tampilkanRiwayatPanggilan() {
  const daftar = antrian.getRiwayatDipanggil();
  riwayatPanggilan.replaceChildren(
    ...daftar.map((nomor) => {
      const item = document.createElement('li');
      item.textContent = nomor;
      return item;
    }),
  );
  riwayatKosong.hidden = daftar.length > 0;
  riwayatPanggilan.hidden = daftar.length === 0;
}

function tampilkanEditor() {
  tombolUndo.disabled = !editor.bisaUndo();
  tombolRedo.disabled = !editor.bisaRedo();
  jumlahRiwayat.textContent = String(editor.getJumlahRiwayat());
}

function panggilBerikutnya() {
  const nomor = antrian.panggilBerikutnya();
  if (nomor === undefined) {
    nomorDipanggil.textContent = '—';
    pesanPanggilan.textContent =
      'Antrean kosong. Belum ada pasien untuk dipanggil.';
    tampilkanAntrean();
    return;
  }

  nomorDipanggil.textContent = nomor;
  pesanPanggilan.textContent = 'Silakan menuju loket pendaftaran.';
  tampilkanAntrean();
  tampilkanRiwayatPanggilan();
}

function ubahCatatan(teks) {
  catatan.value = teks;
  simpanCatatan();
  tampilkanEditor();
}

catatan.value = catatanAwal;
ambilElemen('ambil-nomor').addEventListener('click', () => {
  antrian.ambilNomor();
  tampilkanAntrean();
});

ambilElemen('panggil-berikutnya').addEventListener('click', panggilBerikutnya);

ambilElemen('reset-antrean').addEventListener('click', () => {
  antrian.reset();
  nomorDipanggil.textContent = '—';
  pesanPanggilan.textContent = 'Antrean sudah direset.';
  tampilkanAntrean();
  tampilkanRiwayatPanggilan();
});

catatan.addEventListener('input', () => {
  editor.catatPerubahan(catatan.value);
  simpanCatatan();
  tampilkanEditor();
});

tombolUndo.addEventListener('click', () => {
  const teks = editor.undo();
  if (teks !== undefined) ubahCatatan(teks);
});

tombolRedo.addEventListener('click', () => {
  const teks = editor.redo();
  if (teks !== undefined) ubahCatatan(teks);
});

catatan.addEventListener('keydown', (event) => {
  if (!event.ctrlKey || event.altKey || event.metaKey) return;

  const tombol = event.key.toLowerCase();
  if (tombol === 'z' && !event.shiftKey) {
    event.preventDefault();
    tombolUndo.click();
  } else if (tombol === 'y' || (tombol === 'z' && event.shiftKey)) {
    event.preventDefault();
    tombolRedo.click();
  }
});

tampilkanAntrean();
tampilkanRiwayatPanggilan();
tampilkanEditor();
