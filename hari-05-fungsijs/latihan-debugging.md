# Contoh Perbaikan Debugging Fungsi dan DOM

Contoh ini menunjukkan perbaikan delapan kesalahan pada fungsi dan DOM:

- [`bug-fungsi.js`](./bug-fungsi.js): menambahkan `return`, menangani array
  kosong sebelum menghitung rata-rata, dan mengurutkan angka dengan fungsi
  pembanding.
- [`bug-dom.html`](./bug-dom.html): menyamakan huruf pada ID elemen, menjalankan
  script setelah elemen tersedia, mencegah form memuat ulang halaman, memakai
  `let` pada loop, dan menampilkan input dengan `textContent`.

## Menjalankan dan memeriksa

Jalankan contoh fungsi dari terminal:

```bash
node bug-fungsi.js
```

Buka [`bug-dom.html`](./bug-dom.html) di browser. Kirim pesan dan klik setiap
tombol contoh untuk memeriksa hasilnya. Form tidak memuat ulang halaman, dan
teks yang dimasukkan ditampilkan sebagai teks biasa.
