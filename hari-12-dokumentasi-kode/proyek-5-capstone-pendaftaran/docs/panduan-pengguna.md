# Panduan Pengguna

## Untuk peserta

1. Buka halaman depan aplikasi dan periksa daftar kelas serta sisa kuotanya.
2. Pilih **Daftar Sekarang**, isi nama, email, nomor HP, alamat, dan kelas, lalu
   kirim formulir. Nomor HP harus diawali `08` dan berjumlah 10–13 digit.
3. Jika isian tidak valid, perbaiki kolom yang ditandai. Email yang sudah dipakai
   tidak dapat didaftarkan kembali.
4. Jika kelas penuh sebelum formulir tersimpan, pilih kelas lain yang kuotanya
   masih tersedia.
5. Setelah pendaftaran berhasil, pilih **Cetak bukti pendaftaran** untuk membuka
   PDF. Tautan publik tersebut hanya berlaku untuk pendaftaran terakhir pada sesi
   browser yang sama; admin juga dapat mencetak bukti dari panel admin.

## Untuk admin

1. Masuk dari **Login admin** memakai akun yang dibuat saat instalasi.
2. Halaman **Pendaftar** menampilkan seluruh pendaftar. Gunakan kotak pencarian
   DataTables untuk mencari nama, email, atau nomor HP, dan pilih kelas pada
   **Filter kelas** untuk menyaring daftar. Tabel dapat diurutkan dan dibagi
   menjadi halaman.
3. Pilih **Ubah** untuk memperbarui data. Email harus tetap unik dan kuota kelas
   tujuan harus tersedia. Kuota kelas yang sedang diikuti peserta tersebut tidak
   dianggap penuh hanya karena peserta itu sendiri.
4. Pilih **Cetak** untuk membuka bukti pendaftaran PDF. Gunakan dialog cetak
   browser untuk mencetak atau menyimpan PDF.
5. Pilih **Hapus** untuk menghapus pendaftar. SweetAlert2 meminta konfirmasi;
   jika CDN tidak tersedia, browser memakai konfirmasi bawaan.
6. Pilih **Kelas** untuk menambah, mengubah, dan menghapus kelas. Kuota tidak
   boleh negatif atau lebih kecil daripada jumlah peserta saat ini. Kelas yang
   masih memiliki pendaftar tidak dapat dihapus.
7. Pilih **Logout** untuk mengakhiri sesi. Permintaan logout dikirim dengan POST
   dan token CSRF.

## Jika terjadi masalah

- **Aplikasi tidak terhubung ke database:** pastikan MySQL hidup, database sudah
  diimpor, dan `config/config.php` berisi pengaturan yang benar.
- **Kelas tidak muncul:** admin perlu menambahkan kelas atau menjalankan kembali
  seed kelas pada instalasi baru.
- **Halaman menampilkan kesalahan umum:** periksa log PHP/Apache lokal. Detail
  exception tidak ditampilkan ke pengguna.
- **Tampilan library tidak termuat:** pastikan browser dapat mengakses CDN.
  Proses pendaftaran dan validasi server tetap dilakukan oleh aplikasi.
