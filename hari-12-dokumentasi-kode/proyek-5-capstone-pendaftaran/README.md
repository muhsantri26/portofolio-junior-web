# Sistem Pendaftaran Pelatihan

Aplikasi web untuk pendaftaran peserta pelatihan dan pengelolaan kelas oleh admin.

## Fitur

- Formulir pendaftaran publik responsif dengan validasi di browser dan server.
- CRUD pendaftar dan kelas menggunakan PDO prepared statement.
- Kuota kelas diperiksa dalam transaksi agar pendaftaran serentak tidak melampaui kuota.
- Panel admin dengan pencarian, filter kelas, dan paginasi DataTables.
- Login admin dengan password hash, sesi aman, pembatasan percobaan, dan perlindungan CSRF.
- Konfirmasi hapus dengan SweetAlert2 dan bukti pendaftaran PDF dengan Dompdf.
- Pesan kesalahan umum dicatat ke log PHP tanpa menampilkan detail internal ke pengunjung.

## Teknologi

PHP 8.1+, MySQL/MariaDB dengan InnoDB, PDO MySQL, Composer, Bootstrap 5, jQuery,
DataTables, SweetAlert2, dan Dompdf. Bootstrap, jQuery, DataTables, dan SweetAlert2
dimuat dari CDN sehingga browser memerlukan koneksi internet.

## Instalasi dari nol

1. Pastikan PHP memiliki ekstensi `pdo_mysql` dan `mbstring`, lalu pasang Composer.
2. Salin folder proyek ke direktori web, misalnya `C:\xampp\htdocs\pendaftaran`.
3. Impor `database/skema.sql` melalui phpMyAdmin atau klien MySQL. Skema membuat
   database `db_pelatihan`, tabel aplikasi, dan dua kelas contoh.
4. Salin `config/config.contoh.php` menjadi `config/config.php`, lalu sesuaikan
   host, nama database, username, dan sandi database. Jangan masukkan kredensial
   nyata ke Git.
5. Dari direktori proyek jalankan `composer install`.
6. Buat akun admin dengan `php database/buat-admin.php <username> <kata-sandi>`.
   Pilih kata sandi kuat dan jangan menggunakan contoh atau kata sandi yang dipakai
   di layanan lain.
7. Buka `http://localhost/pendaftaran/public/`. Admin masuk melalui tautan **Login admin**.

Pastikan service MySQL berjalan sebelum membuka aplikasi. Jika proyek ditempatkan
di alamat atau subfolder berbeda, sesuaikan URL yang dibuka; tautan aplikasi
menggunakan rute relatif di dalam `public/`.

## Pengujian

Jalankan tes otomatis tanpa koneksi database:

```text
php tests/jalankan.php
```

Tes integrasi manual yang memerlukan MySQL/XAMPP ada di
[`docs/kasus-uji.md`](docs/kasus-uji.md). Tes otomatis memakai PDO test double,
jadi tidak menggantikan pemeriksaan transaksi dan tampilan pada instalasi MySQL.

## Dokumentasi

- [Panduan pengguna](docs/panduan-pengguna.md)
- [Arsitektur dan keputusan struktur data](docs/arsitektur.md)
- [Peta modul](docs/peta-modul.md)
- [Dokumen modul autentikasi](docs/modul/auth.md)
- [Dokumen modul kelas](docs/modul/kelas.md)
- [Dokumen modul pendaftar](docs/modul/pendaftar.md)
- [Kasus uji dan regresi](docs/kasus-uji.md)
- [Laporan bug](docs/laporan-bug.md)
- [Dokumentasi API PHP](docs/api/index.html)
- [Dokumentasi API JavaScript](docs/api-js/index.html)

## Struktur folder

```text
config/       Pengaturan lokal dan koneksi database
database/     Skema database dan utilitas pembuatan admin
docs/         Panduan, dokumentasi modul, kasus uji, dan API
public/       Halaman web dan aset yang dapat diakses melalui browser
src/          Fungsi aplikasi, autentikasi, validasi, dan transaksi
templates/    Kerangka halaman dan template bukti PDF
tests/        Tes otomatis mandiri
```

## Lisensi dan penulis

Komponen pihak ketiga mengikuti lisensinya masing-masing; lihat `composer.lock`
dan dokumentasi library. Kode proyek ditujukan untuk latihan dan portofolio.
