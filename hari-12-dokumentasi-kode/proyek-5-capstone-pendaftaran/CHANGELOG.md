# Changelog

Perubahan penting pada proyek dicatat di sini.

## [1.0.0] - 2026-11-03

### Ditambahkan

- CRUD kelas dan ringkasan kelas admin berdasarkan jumlah pendaftar.
- Filter kelas, pencarian, dan paginasi pada tabel pendaftar DataTables.
- Validasi server untuk nama kelas, kuota, ID kelas, alamat, dan batas panjang kolom.
- Pemeriksaan kuota transaksional saat pendaftar ditambah atau dipindahkan kelas.
- Tes otomatis mandiri, panduan pengguna, dan dokumentasi modul kelas.

### Diperbaiki

- Pemakaian placeholder PDO berulang yang gagal dengan prepared statement native.
- Pencegahan penghapusan kelas yang masih memiliki peserta dan penurunan kuota di bawah jumlah pendaftar.
- Perlindungan CSRF pada logout; logout sekarang hanya menerima POST.
- Pengaturan cookie sesi `HttpOnly`, `SameSite=Lax`, dan `Secure` saat HTTPS.
- Skema SQL yang sebelumnya berisi teks non-SQL dan tidak dapat diimpor utuh.
- `config/config.contoh.php` yang sebelumnya kosong.
- Ketidaksesuaian jumlah pencarian peserta dengan kolom yang dapat dicari.

## [0.2.0] - Sebelumnya

### Ditambahkan

- Antarmuka Bootstrap, DataTables, dan SweetAlert2.
- Panel pendaftar, autentikasi admin, kuota kelas, dan cetak bukti PDF.
