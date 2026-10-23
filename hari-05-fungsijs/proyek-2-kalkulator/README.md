# Proyek 2: Kalkulator dan Validasi Formulir

Proyek ini berisi dua latihan aplikasi web sederhana menggunakan HTML, CSS,
JavaScript, dan modul ES:

1. **Kalkulator** untuk operasi hitung dasar.
2. **Validator formulir** untuk memeriksa data pendaftaran sebelum dikirim.

## Struktur Proyek

```text
proyek-2-kalkulator/
├── kalkulator/
│   ├── index.html
│   ├── css/
│   │   └── style.css
│   └── js/
│       ├── app.js
│       └── operasi.js
└── validator/
    ├── index.html
    ├── css/
    │   └── style.css
    └── js/
        ├── app.js
        └── aturan.js
```

## Menjalankan Aplikasi

Jalankan masing-masing `index.html` menggunakan server lokal, misalnya ekstensi
**Live Server** di Visual Studio Code. Modul JavaScript ES sebaiknya dijalankan
melalui server lokal, bukan dengan membuka berkas langsung menggunakan alamat
`file:///`.

- Kalkulator: buka [`kalkulator/index.html`](./kalkulator/index.html).
- Validator formulir: buka [`validator/index.html`](./validator/index.html).

Tidak diperlukan instalasi dependensi.

## Fitur Kalkulator

- Operasi penjumlahan, pengurangan, perkalian, dan pembagian.
- Input angka desimal.
- Tombol `C` untuk menghapus perhitungan.
- Menampilkan pesan jika mencoba membagi dengan nol.
- Logika operasi disediakan sebagai modul ES di `kalkulator/js/operasi.js`.

## Fitur Validator Formulir

- Memeriksa nama minimal 3 karakter.
- Memeriksa format email.
- Memeriksa nomor HP yang diawali `08` dengan panjang 10–13 digit.
- Memeriksa sandi minimal 8 karakter yang berisi huruf dan angka.
- Memastikan konfirmasi sandi sama dengan sandi.
- Menampilkan pesan kesalahan pada setiap kolom dan ringkasan jika pendaftaran
  berhasil.
- Aturan validasi disediakan sebagai modul ES di `validator/js/aturan.js`.

## Teknologi

- HTML5
- CSS3
- JavaScript ES Modules