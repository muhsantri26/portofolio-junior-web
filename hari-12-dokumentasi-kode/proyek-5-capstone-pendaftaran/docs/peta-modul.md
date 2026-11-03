# Peta Modul

Dokumen ini menjelaskan isi folder `src/` dan `public/` pada proyek pendaftaran. `src/` berisi kode yang dipakai bersama, sedangkan `public/` berisi halaman yang dibuka atau digunakan oleh pengunjung dan admin.

## Folder `src/`

| Berkas | Tanggung jawab |
|---|---|
| [`bootstrap.php`](../src/bootstrap.php) | Menyiapkan sesi, konfigurasi, koneksi database, dan fungsi-fungsi aplikasi. Berkas ini juga menampilkan pesan umum jika terjadi kesalahan sistem. |
| [`helpers.php`](../src/helpers.php) | Menyediakan alat bantu untuk keamanan, pesan sementara, pengalihan halaman, dan pemeriksaan login admin. |
| [`auth.php`](../src/auth.php) | Mencari data admin, memeriksa proses login, membatasi halaman untuk admin, dan mengakhiri sesi login. |
| [`pendaftar.php`](../src/pendaftar.php) | Mengambil, memeriksa, menambah, mengubah, dan menghapus data pendaftar serta memeriksa kuota kelas. |

### Daftar fungsi di `src/`

#### `helpers.php`

| Fungsi | Kegunaan |
|---|---|
| `e($teks)` | Mengamankan teks sebelum ditampilkan di halaman HTML. |
| `redirect($url)` | Mengarahkan pengguna ke alamat halaman lain. |
| `tokenCsrf()` | Membuat atau mengambil token keamanan untuk formulir. |
| `cekCsrf()` | Memeriksa token keamanan saat formulir dikirim. |
| `setFlash($pesan)` | Menyimpan pesan sementara untuk ditampilkan setelah pindah halaman. |
| `ambilFlash()` | Mengambil pesan sementara lalu menghapusnya dari sesi. |
| `cekLoginAdmin()` | Memeriksa apakah admin sudah login; jika belum, pengguna diarahkan ke halaman login. |

#### `auth.php`

| Fungsi | Kegunaan |
|---|---|
| `cariAdmin($pdo, $username)` | Mencari admin berdasarkan nama pengguna. |
| `prosesLogin($pdo, $username, $sandi)` | Memeriksa nama pengguna dan kata sandi, lalu membuat sesi login jika benar. |
| `wajibLogin()` | Menghentikan akses ke halaman admin jika belum login. |
| `logout()` | Menghapus data sesi dan mengakhiri login admin. |

#### `pendaftar.php`

| Fungsi | Kegunaan |
|---|---|
| `daftarKelas($pdo)` | Mengambil daftar kelas yang tersedia. |
| `hitungPendaftar($pdo, $kata)` | Menghitung pendaftar yang namanya cocok dengan kata pencarian. |
| `ambilPendaftar($pdo, $kata, $batas, $offset)` | Mengambil daftar pendaftar berdasarkan nama, dengan batas jumlah dan halaman. |
| `ambilPendaftarById($pdo, $id)` | Mengambil satu pendaftar berdasarkan ID. |
| `emailSudahAda($pdo, $email, $kecualiId)` | Memeriksa apakah email sudah dipakai pendaftar lain. |
| `validasiPendaftar($input, $pdo, $idUbah)` | Memeriksa data formulir dan mengembalikan data yang sudah dirapikan beserta pesan kesalahan. |
| `tambahPendaftar($pdo, $d)` | Menyimpan pendaftar baru ke database. |
| `ubahPendaftar($pdo, $id, $d)` | Memperbarui data pendaftar berdasarkan ID. |
| `hapusPendaftar($pdo, $id)` | Menghapus pendaftar berdasarkan ID. |
| `ambilAdminById($pdo, $id)` | Mengambil data admin berdasarkan ID. |
| `ambilSemuaPendaftar($pdo, $kata, $batas, $offset)` | Mengambil data pendaftar, dengan pencarian opsional pada nama, email, atau nomor HP. |
| `ambilBuktiPendaftar($pdo, $id)` | Mengambil data pendaftar yang diperlukan untuk membuat bukti pendaftaran. |
| `daftarkanDenganKuota($pdo, $data)` | Menyimpan pendaftaran jika kuota kelas masih tersedia. |

`KuotaPenuhException` adalah jenis kesalahan khusus yang menandakan kuota kelas sudah penuh.



## Folder `public/`

| Berkas | Tanggung jawab |
|---|---|
| [`index.php`](../public/index.php) | Menampilkan halaman depan dan tautan untuk mulai mendaftar. |
| [`form.php`](../public/form.php) | Menampilkan formulir pendaftar; dipakai bersama oleh halaman tambah dan ubah. |
| [`tambah.php`](../public/tambah.php) | Menampilkan formulir pendaftaran, memeriksa isinya, dan menyimpan pendaftar baru jika valid serta kuota tersedia. |
| [`ubah.php`](../public/ubah.php) | Memeriksa login admin, menampilkan data pendaftar, dan menyimpan perubahan. |
| [`hapus.php`](../public/hapus.php) | Memeriksa login dan token keamanan, lalu menghapus pendaftar melalui permintaan POST. |
| [`admin.php`](../public/admin.php) | Menampilkan daftar pendaftar untuk admin, termasuk pencarian nama dan navigasi halaman. |
| [`login.php`](../public/login.php) | Menampilkan formulir login admin dan memproses percobaan login. |
| [`logout.php`](../public/logout.php) | Mengakhiri sesi login dan mengarahkan admin kembali ke halaman login. |
| [`cetak.php`](../public/cetak.php) | Membuat dan menampilkan bukti pendaftaran dalam bentuk PDF. |
| [`assets/js/app.js`](../public/assets/js/app.js) | Menampilkan notifikasi, meminta konfirmasi sebelum penghapusan, dan mengatur tabel pendaftar. |

Berkas PHP di `public/` menjalankan tugas halaman atau aksi secara langsung; berkas-berkas tersebut tidak mendeklarasikan fungsi bernama. Fungsi yang dipakai bersama tersedia di folder `src/`.

### Parameter dan hasil lima fungsi

| Fungsi | Parameter (tipe, makna, batasan) | Nilai kembali | Kasus khusus |
|---|---|---|---|
| `validasiPendaftar($input, $pdo, $idUbah)` | `$input`: `array` berisi data formulir; `$pdo`: `PDO` untuk mengakses database; `$idUbah`: `?int` ID pendaftar yang sedang diubah. | `array` dengan isi `data` dan `galat`. | `$idUbah` bernilai `null` saat menambah pendaftar baru. Saat mengubah data, ID digunakan agar email milik pendaftar itu sendiri tidak dianggap duplikat. |
| `ambilPendaftarById($pdo, $id)` | `$pdo`: `PDO` untuk mengakses database; `$id`: `int` ID pendaftar, biasanya angka minimal 1. | `?array` berisi data pendaftar. | Mengembalikan `null` jika pendaftar dengan ID tersebut tidak ditemukan. |
| `emailSudahAda($pdo, $email, $kecualiId)` | `$pdo`: `PDO` untuk mengakses database; `$email`: `string` email yang ingin diperiksa; `$kecualiId`: `?int` ID yang tidak perlu dihitung saat mengubah data. | `bool`: `true` jika email sudah dipakai pendaftar lain, `false` jika belum. | `$kecualiId` bernilai `null` saat pendaftar baru ditambahkan. |
| `tambahPendaftar($pdo, $d)` | `$pdo`: `PDO` untuk mengakses database; `$d`: `array` data pendaftar, berisi nama, email, nomor HP, alamat, dan ID kelas. | `bool`: hasil penyimpanan ke database. | Data sebaiknya sudah diperiksa dengan `validasiPendaftar()` sebelum fungsi ini dipanggil. |
| `daftarkanDenganKuota($pdo, $data)` | `$pdo`: `PDO` untuk mengakses database; `$data`: `array` data pendaftaran yang sudah diperiksa dan menyertakan `kelas_id`. | Tidak mengembalikan nilai (`void`). | Melempar `KuotaPenuhException` jika kuota kelas habis. Jika terjadi kesalahan lain, transaksi dibatalkan dan kesalahan diteruskan. |