# Dokumen Modul Pendaftar

| Bagian | Isi |
|---|---|
| ID modul / berkas | MOD-PEN-001 / [`src/pendaftar.php`](../../src/pendaftar.php) |
| Versi dan status | 1.0.0 / aktif |
| Penulis dan tanggal | Muhsantri / 3 November 2026 |
| Kegunaan | Mengelola data pendaftar dan kelas, mulai dari mengambil dan memeriksa data sampai menambah, mengubah, dan menghapus pendaftar. Modul juga memastikan kuota kelas tidak terlampaui saat pendaftaran baru. |
| Dependensi | `PDO` dari PHP untuk mengakses database dan tabel `pendaftar`, `kelas`, serta `admin`. Koneksi database disiapkan di [`config/database.php`](../../config/database.php) dan berkas modul dimuat melalui [`src/bootstrap.php`](../../src/bootstrap.php). |
| Fungsi publik | `daftarKelas()`, `hitungPendaftar()`, `ambilPendaftar()`, `ambilPendaftarById()`, `emailSudahAda()`, `validasiPendaftar()`, `tambahPendaftar()`, `ubahPendaftar()`, `hapusPendaftar()`, `ambilAdminById()`, `ambilSemuaPendaftar()`, `ambilBuktiPendaftar()`, `daftarkanDenganKuota()` |
| Catatan keamanan | Query database menggunakan parameter agar nilai masukan tidak langsung digabungkan ke SQL. Data formulir diperiksa sebelum disimpan. Pendaftaran dengan kuota memakai transaksi dan mengunci data kelas saat menghitung kuota. Token CSRF diperiksa oleh halaman yang menerima formulir, sedangkan pengamanan teks HTML dilakukan dengan fungsi `e()` dari `src/helpers.php`. |
| Contoh pemakaian | Halaman [`public/tambah.php`](../../public/tambah.php) memakai `daftarKelas()`, `validasiPendaftar()`, dan `daftarkanDenganKuota()` untuk menerima pendaftaran. Halaman admin memakai fungsi untuk mencari dan mengelola data pendaftar. |

## Ringkasan fungsi

| Fungsi | Kegunaan |
|---|---|
| `daftarKelas(PDO $pdo): array` | Mengambil daftar ID dan nama kelas dari database. |
| `hitungPendaftar(PDO $pdo, string $kata): int` | Menghitung jumlah pendaftar dengan nama yang cocok dengan kata pencarian. |
| `ambilPendaftar(PDO $pdo, string $kata, int $batas, int $offset): array` | Mengambil pendaftar berdasarkan kecocokan nama, dengan batas jumlah baris dan posisi awal untuk halaman. |
| `ambilPendaftarById(PDO $pdo, int $id): ?array` | Mengambil satu pendaftar berdasarkan ID. Mengembalikan `null` jika tidak ditemukan. |
| `emailSudahAda(PDO $pdo, string $email, ?int $kecualiId): bool` | Memeriksa apakah email sudah dipakai. `$kecualiId` digunakan saat mengubah data agar pendaftar tersebut tidak dianggap duplikat. |
| `validasiPendaftar(array $input, PDO $pdo, ?int $idUbah): array` | Merapikan dan memeriksa nama, email, nomor HP, dan kelas. Mengembalikan `data` dan `galat`; `galat` kosong jika semua data valid. `$idUbah` bernilai `null` saat menambah pendaftar. |
| `tambahPendaftar(PDO $pdo, array $d): bool` | Menyimpan data pendaftar baru dan mengembalikan hasil penyimpanan. |
| `ubahPendaftar(PDO $pdo, int $id, array $d): bool` | Memperbarui data pendaftar dengan ID tertentu dan mengembalikan hasil penyimpanan. |
| `hapusPendaftar(PDO $pdo, int $id): bool` | Menghapus pendaftar dengan ID tertentu dan mengembalikan hasil penghapusan. |
| `ambilAdminById(PDO $pdo, int $id): ?array` | Mengambil data admin berdasarkan ID. Mengembalikan `null` jika tidak ditemukan. |
| `ambilSemuaPendaftar(PDO $pdo, string $kata = '', int $batas = 0, int $offset = 0): array` | Mengambil pendaftar dan nama kelas. Pencarian mencocokkan nama, email, atau nomor HP; batas dapat dipakai untuk membagi hasil per halaman. |
| `ambilBuktiPendaftar(PDO $pdo, int $id): ?array` | Mengambil data pendaftar dan kelas untuk bukti pendaftaran. Mengembalikan `null` jika tidak ditemukan. |
| `daftarkanDenganKuota(PDO $pdo, array $data): void` | Memeriksa kuota dalam transaksi lalu menyimpan pendaftar. Melempar `KuotaPenuhException` jika kuota kelas sudah penuh. |

`KuotaPenuhException` adalah jenis kesalahan khusus yang digunakan untuk memberi tahu halaman bahwa kelas yang dipilih sudah penuh.

## Riwayat revisi

| Versi | Tanggal | Perubahan | Penulis |
|---|---|---|---|
| 1.0.0 | 3 November 2026 | Membuat dokumentasi tanggung jawab modul, fungsi publik, dependensi, dan catatan keamanan. | Muhsantri |