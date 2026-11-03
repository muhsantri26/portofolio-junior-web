# Sistem Pendaftaran Pelatihan 
Aplikasi web pendaftaran peserta pelatihan (PHP, MySQL, Bootstrap). 
 
## Fitur - Form pendaftaran publik dengan validasi - Panel admin: daftar (DataTables), ubah, hapus, cetak bukti PDF - Kuota kelas dan login admin 
 
## Teknologi dan Library 
PHP 8.x, MySQL/MariaDB, Bootstrap 5 (MIT), DataTables (MIT), SweetAlert2 (MIT), 
Dompdf (LGPL) 
 
## Persyaratan 
XAMPP/Laragon dengan PHP 8.1+, MySQL, Composer 
 
## Instalasi 
1. Salin proyek ke `htdocs/pendaftaran` 
2. Buat database dan impor `database/skema.sql` 
3. Salin `config/config.contoh.php` menjadi `config/config.php`, isi kredensial 
4. Jalankan `composer install` 
5. Buat admin: `php database/buat-admin.php admin SandiKuat123` 
6. Buka `http://localhost/pendaftaran/public/` 
 
## Struktur Folder 
config/, src/, public/, templates/, database/, docs/, tests/ 
 
## Pengujian 
`php tests/jalankan.php` dan skenario manual di `docs/kasus-uji.md` 
 
## Dokumentasi 
API: `docs/api/index.html`, laporan bug: `docs/laporan-bug.md`, library: 
`docs/daftar-library.md` 
 
## Lisensi dan Penulis 
Nama Peserta - lisensi MIT 