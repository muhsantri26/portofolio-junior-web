# T7. Laporan Bug

## Template catatan bug

| Kolom | Isi |
| --- | --- |
| ID | B-01, B-02, ... |
| Jenis | Syntax / Runtime / Logic |
| Tingkat keparahan | Kritis, Tinggi, Sedang, Rendah |
| Lokasi | Berkas:baris atau halaman |
| Langkah reproduksi | Urutan langkah |
| Hasil diharapkan vs aktual | Perbandingan |
| Pesan/kode error | Salinan lengkap |
| Penyebab | Akarnya masalah |
| Perbaikan | Perubahan yang dilakukan |
| Hasil re-test | Lolos/Gagal, tanggal |

## Contoh laporan bug

| ID | Jenis | Tingkat keparahan | Lokasi | Langkah reproduksi | Hasil diharapkan | Hasil aktual | Pesan/kode error | Penyebab | Perbaikan | Hasil re-test |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| B-01 | Logic | Tinggi | public/admin.php | Login admin lalu buka daftar | Tabel menampilkan data yang sesuai | Error karena fungsi menerima argumen tidak sesuai | Undefined argument count | Fungsi `ambilSemuaPendaftar()` tidak kompatibel dengan pemanggilan dari admin | Menyesuaikan signature fungsi dan paginasi | Lolos, 2026-11-03 |
| B-02 | Runtime | Sedang | public/login.php | Login dengan akun valid | Redirect ke dashboard | Sistem tetap gagal login | `admin_id` tidak diset dengan benar | Login hanya menyetel variabel sementara dan tidak memvalidasi database | Menggunakan `prosesLogin()` dengan validasi data admin | Lolos, 2026-11-03 |
| B-03 | Logic | Tinggi | src/helpers.php | Akses halaman admin tanpa login | Redirect ke `login.php` | Halaman tetap terbuka | Session admin tidak terdeteksi | Fungsi `cekLoginAdmin()` memeriksa key session yang salah | Memperbaiki pengecekan `admin_id` | Lolos, 2026-11-03 |
| B-04 | Runtime | Rendah | public/logout.php | Klik logout | Session dibersihkan dan redirect | Session tidak bersih sepenuhnya | User tetap terlihat login | `unset($_SESSION['admin_id'])` saja tidak menghapus semua session | Menghapus seluruh session dan cookie | Lolos, 2026-11-03 |
| B-05 | Logic | Sedang | public/index.php | Buka halaman utama | Memuat halaman pendaftaran user | Halaman menampilkan teks dummy dan bukan alur pendaftaran | `halaman user` | Halaman utama tidak mengarahkan ke flow pendaftaran | Mengubah landing page menjadi halaman pendaftaran/promo | Lolos, 2026-11-03 |

## Catatan

- Laporan bug dibuat berdasarkan pengujian sistem pada modul pendaftaran pelatihan.
- Setelah perbaikan, hasil re-test disimpan sebagai bukti kelayakan aplikasi.
