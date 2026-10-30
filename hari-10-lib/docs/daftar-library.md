# Daftar Library Sprint 1

Dokumen ini mencatat library yang dipakai dan alasan pemilihannya. Versi acuan mengikuti daftar T7. Rilis terbaru hanya sebagai referensi, bukan berarti versi proyek otomatis berubah.

## T7. Library yang Dipakai

### Bootstrap 5.3

Membantu membuat tampilan dan komponen yang responsif. Bootstrap JS Bundle sudah menyertakan Popper. Untuk komponen interaktif, gunakan atribut `data-bs-*`.

### SweetAlert2 11

Menampilkan konfirmasi dan notifikasi yang lebih jelas. Bisa digunakan sebagai pengganti `alert()` dan `confirm()` bawaan browser. Tidak memerlukan dependency tambahan.

### jQuery 3.7

Memudahkan manipulasi halaman dan dibutuhkan DataTables 1.x. Pada proyek ini, jQuery dipakai untuk kebutuhan DataTables saja.

### DataTables 1.13

Menambahkan fitur pencarian, pengurutan, dan pagination pada tabel. Library ini membutuhkan jQuery dan cocok untuk data dalam jumlah yang tidak terlalu besar.

### Dompdf

Membuat PDF dari HTML dan CSS. Membutuhkan PHP, ekstensi `mbstring` dan `dom`, serta beberapa paket Composer. Cocok untuk dokumen sederhana yang sudah dibuat dalam HTML.

### FPDF

Membuat PDF dengan mengatur posisi teks dan elemen secara langsung. Tidak membutuhkan library tambahan dan cocok jika dokumen tidak perlu dibuat dari HTML.

## T3. Analisis Pemilihan Library

Analisis berikut memakai kriteria pada daftar: kesesuaian kebutuhan, lisensi, pemeliharaan, popularitas dan komunitas, kompatibilitas, keamanan, ukuran dan performa, serta kemudahan migrasi. Perkiraan waktu yang dihemat bersifat kasar, bukan hasil pengukuran.

### Bootstrap 5.3

- **Versi acuan:** 5.3. Rilis terbaru yang ditemukan adalah 5.3.8 ([npm](https://www.npmjs.com/package/bootstrap)).
- **Kesesuaian kebutuhan:** Cocok untuk membuat tampilan dan komponen responsif. Alternatifnya, gunakan CSS sendiri atau Tailwind CSS.
- **Lisensi:** MIT.
- **Pemeliharaan:** Rilis terbaru menunjukkan proyek masih mendapat pembaruan. Periksa catatan rilis sebelum memperbarui.
- **Popularitas dan komunitas:** Banyak digunakan dan memiliki dokumentasi serta komunitas yang luas.
- **Kompatibilitas:** Mendukung browser modern. Komponen JavaScript tertentu memerlukan Popper, yang sudah disertakan dalam JS Bundle.
- **Keamanan:** Perbarui ke versi yang didukung dan gunakan komponen sesuai dokumentasi. Hindari memasukkan konten pengguna yang belum diamankan.
- **Ukuran dan performa:** Memuat CSS dan JavaScript tambahan; gunakan berkas yang diperlukan saja agar halaman tetap ringan.
- **Kemudahan migrasi:** Relatif mudah diganti dengan CSS sendiri, tetapi tampilan dan komponen perlu disesuaikan.
- **Perkiraan penghematan:** 4–6 jam untuk menyiapkan tampilan dasar.

### SweetAlert2 11

- **Versi acuan:** 11. Rilis terbaru yang ditemukan adalah 11.26.25 ([npm](https://www.npmjs.com/package/sweetalert2)).
- **Kesesuaian kebutuhan:** Cocok untuk konfirmasi dan notifikasi yang lebih jelas. Alternatif sederhana adalah `alert()` dan `confirm()` bawaan browser.
- **Lisensi:** MIT.
- **Pemeliharaan:** Rilis terbaru menunjukkan proyek masih mendapat pembaruan. Periksa catatan rilis sebelum memperbarui.
- **Popularitas dan komunitas:** Banyak digunakan dan memiliki dokumentasi penggunaan.
- **Kompatibilitas:** Berjalan di browser modern dan tidak membutuhkan dependency tambahan.
- **Keamanan:** Tampilkan teks dari pengguna sebagai teks biasa. Jangan memasukkan HTML yang belum diamankan ke dalam dialog.
- **Ukuran dan performa:** Menambah berkas JavaScript dan CSS; gunakan hanya jika dialog khusus memang dibutuhkan.
- **Kemudahan migrasi:** Mudah diganti dengan dialog bawaan browser, tetapi tampilan dan cara pemanggilannya perlu disesuaikan.
- **Perkiraan penghematan:** 1–2 jam untuk membuat dialog dasar.

### jQuery 3.7

- **Versi acuan:** 3.7. Rilis terbaru yang ditemukan adalah 4.0.0 ([npm](https://www.npmjs.com/package/jquery)).
- **Kesesuaian kebutuhan:** Digunakan karena DataTables 1.x membutuhkannya. Jika DataTables tidak dipakai, manipulasi halaman dapat menggunakan JavaScript biasa.
- **Lisensi:** MIT.
- **Pemeliharaan:** Periksa catatan rilis dan dukungan plugin sebelum memperbarui versi.
- **Popularitas dan komunitas:** Sudah lama digunakan dan memiliki banyak dokumentasi serta plugin.
- **Kompatibilitas:** Versi 3.7 cocok dengan DataTables 1.x. Jangan memperbarui ke versi mayor baru tanpa memastikan plugin yang dipakai tetap kompatibel.
- **Keamanan:** Gunakan versi yang diperbarui dan hindari memasukkan HTML dari pengguna tanpa validasi.
- **Ukuran dan performa:** Menambah satu berkas JavaScript. Dampaknya biasanya kecil untuk halaman sederhana, tetapi hindari memuatnya jika tidak diperlukan.
- **Kemudahan migrasi:** Dapat diganti dengan JavaScript biasa, tetapi kode yang memakai fungsi jQuery perlu ditulis ulang.
- **Perkiraan penghematan:** Sekitar 1 jam untuk manipulasi DOM sederhana.

### DataTables 1.13

- **Versi acuan:** 1.13. Rilis terbaru yang ditemukan adalah 3.1.4 ([situs resmi](https://datatables.net/download/)).
- **Kesesuaian kebutuhan:** Cocok untuk menambahkan pencarian, pengurutan, dan pagination. Alternatifnya adalah membuat fitur sendiri atau menggunakan Tabulator.
- **Lisensi:** MIT.
- **Pemeliharaan:** Versi terbaru menunjukkan proyek masih mendapat pembaruan. Periksa panduan migrasi dan catatan rilis sebelum berpindah versi mayor.
- **Popularitas dan komunitas:** Banyak digunakan untuk menambahkan fitur pada tabel dan memiliki dokumentasi resmi.
- **Kompatibilitas:** DataTables 1.x membutuhkan jQuery. Pastikan versi jQuery dan ekstensi yang digunakan saling cocok.
- **Keamanan:** Pastikan data yang ditampilkan sudah diamankan dan perbarui library jika ada perbaikan keamanan.
- **Ukuran dan performa:** Menambah berkas JavaScript dan CSS. Cocok untuk tabel yang tidak terlalu besar; kebutuhan data besar mungkin memerlukan pemrosesan di server.
- **Kemudahan migrasi:** Bisa diganti dengan tabel HTML biasa atau library lain, tetapi pencarian, pengurutan, dan pagination perlu disesuaikan.
- **Perkiraan penghematan:** 2–4 jam untuk menyiapkan fitur tabel dasar.

### Dompdf 3.1.6

- **Versi acuan:** 3.1.6. Rilis terbaru yang ditemukan adalah 3.1.6 ([Packagist](https://packagist.org/packages/dompdf/dompdf), dirilis 20 Juli 2026).
- **Kesesuaian kebutuhan:** Cocok untuk membuat PDF dari HTML dan CSS. Alternatifnya adalah FPDF, yang mengatur posisi elemen secara langsung.
- **Lisensi:** LGPL-2.1.
- **Pemeliharaan:** Periksa rilis dan catatan perubahan di Packagist sebelum memperbarui.
- **Popularitas dan komunitas:** Tersedia melalui Composer dan memiliki dokumentasi serta laporan masalah di repositori proyek.
- **Kompatibilitas:** Membutuhkan PHP 7.1 atau lebih baru, ekstensi `dom` dan `mbstring`, serta paket pendukung Composer. Hasil CSS tidak selalu sama persis dengan browser.
- **Keamanan:** Batasi sumber HTML dan gambar yang diproses. Jangan mengaktifkan akses ke berkas lokal atau sumber luar jika tidak diperlukan.
- **Ukuran dan performa:** Memerlukan beberapa paket pendukung dan dapat memakai lebih banyak memori saat membuat PDF besar.
- **Kemudahan migrasi:** Dapat diganti dengan FPDF, tetapi templat HTML perlu dibuat ulang dengan pengaturan posisi elemen.
- **Perkiraan penghematan:** 3–5 jam untuk membuat PDF sederhana dari HTML.

### FPDF 1.9

- **Versi acuan:** 1.9. Rilis terbaru yang ditemukan adalah 1.9, dirilis 31 Mei 2026 ([situs resmi](https://www.fpdf.org/en/download.php)).
- **Kesesuaian kebutuhan:** Cocok untuk membuat PDF sederhana tanpa HTML. Alternatifnya adalah Dompdf jika tata letak ingin dibuat menggunakan HTML.
- **Lisensi:** Dapat digunakan secara gratis; periksa ketentuan penggunaan di situs resminya.
- **Pemeliharaan:** Periksa halaman unduhan dan catatan perubahan di situs resmi untuk mengetahui pembaruan.
- **Popularitas dan komunitas:** Sudah lama digunakan dan menyediakan dokumentasi serta contoh di situs resmi.
- **Kompatibilitas:** Membutuhkan PHP dan tidak memerlukan library tambahan. Tata letak PDF diatur melalui kode.
- **Keamanan:** Periksa dan amankan data yang dimasukkan ke dalam PDF. Gunakan sumber library resmi.
- **Ukuran dan performa:** Ringan karena tidak memerlukan paket tambahan; cocok untuk dokumen sederhana.
- **Kemudahan migrasi:** Dapat diganti dengan Dompdf, tetapi proses pembuatan PDF perlu diubah menjadi templat HTML.
- **Perkiraan penghematan:** 2–3 jam untuk membuat PDF sederhana.

> Catatan: versi terbaru di atas diperiksa pada 30 Oktober 2026. Pastikan kembali kompatibilitas dan lisensinya sebelum memperbarui dependency proyek.
