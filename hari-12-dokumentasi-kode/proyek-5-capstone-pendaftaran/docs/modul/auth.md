# Dokumen Modul Autentikasi Admin

| Bagian | Isi |
|---|---|
| ID modul / berkas | MOD-AUT-001 / [`src/auth.php`](../../src/auth.php) |
| Versi dan status | 1.0.0 / aktif |
| Penulis dan tanggal | Muhsantri / 3 November 2026 |
| Kegunaan | Memeriksa identitas admin saat login dan membatasi akses halaman admin untuk pengguna yang sudah login. |
| Dependensi | [`config/database.php`](../../config/database.php) untuk koneksi database dan [`src/helpers.php`](../../src/helpers.php) untuk fungsi pengalihan halaman. Keduanya dimuat melalui [`src/bootstrap.php`](../../src/bootstrap.php). |
| Fungsi publik | `cariAdmin()`, `prosesLogin()`, `wajibLogin()`, `logout()` |
| Catatan keamanan | Pencarian admin memakai query berparameter. Kata sandi diperiksa dengan `password_verify()`, dan ID sesi diperbarui setelah login berhasil. Pesan gagal login tidak membedakan username dengan kata sandi yang salah. Halaman login membatasi percobaan menjadi lima kali per sesi. `public/logout.php` menghapus sesi dan cookie secara langsung; saat ini proses logout tersebut tidak memakai permintaan POST atau pemeriksaan CSRF. |
| Contoh pemakaian | Panggil `wajibLogin();` di awal halaman khusus admin, misalnya [`public/admin.php`](../../public/admin.php). Fungsi `prosesLogin()` digunakan oleh [`public/login.php`](../../public/login.php). |

## Ringkasan fungsi

| Fungsi | Kegunaan |
|---|---|
| `cariAdmin(PDO $pdo, string $username): ?array` | Mencari data admin berdasarkan username. Mengembalikan data admin jika ditemukan, atau `null` jika tidak ada. |
| `prosesLogin(PDO $pdo, string $username, string $sandi): bool` | Memeriksa username dan kata sandi. Jika benar, memperbarui ID sesi dan menyimpan ID admin ke sesi; mengembalikan `true`. Jika salah, mengembalikan `false`. |
| `wajibLogin(): void` | Memeriksa apakah ID admin tersimpan di sesi. Jika belum login, mengarahkan pengguna ke halaman login. |
| `logout(): void` | Mengosongkan data sesi, menghapus cookie sesi, dan mengakhiri sesi. |

## Riwayat revisi

| Versi | Tanggal | Perubahan | Penulis |
|---|---|---|---|
| 1.0.0 | 3 November 2026 | Membuat dokumentasi fungsi, dependensi, contoh penggunaan, dan catatan keamanan modul autentikasi. | Muhsantri |