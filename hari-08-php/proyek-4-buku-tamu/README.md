# Proyek 4 - Buku Tamu

## Fitur

- Validasi nama, email, dan pesan di server; data yang sudah diisi tetap tampil jika validasi gagal.
- Penyimpanan data ke `data/tamu.json` dengan JSON dan pembuatan folder data otomatis.
- Pesan terbaru tampil lebih dulu, pencarian nama, dan paginasi lima pesan per halaman.
- Pembatasan satu kiriman per alamat IP dalam 30 detik.
- Halaman admin untuk menghapus pesan dan mengekspor seluruh data ke CSV.
- Output HTML di-escape. Perubahan data menggunakan pola Post/Redirect/Get.
- Folder `data/` dibatasi oleh `.htaccess`.

## Menjalankan dengan XAMPP

1. Pastikan ekstensi PHP `mbstring` aktif.
2. Atur password admin sebagai variabel lingkungan Apache `BUKU_TAMU_ADMIN_PASSWORD`.
   Di konfigurasi Apache XAMPP, tambahkan `SetEnv BUKU_TAMU_ADMIN_PASSWORD "password-kuat"` pada konfigurasi server atau VirtualHost, lalu restart Apache. Jangan menaruh password pada file PHP atau Git.
3. Buka `http://localhost/portofolio-junior-web/hari-8-php/proyek-4-buku-tamu/` untuk buku tamu.
4. Buka `http://localhost/portofolio-junior-web/hari-8-php/proyek-4-buku-tamu/admin.php` untuk mengelola pesan. Browser akan meminta autentikasi Basic menggunakan password yang sama; username boleh diisi nilai apa pun.

Gunakan HTTPS jika admin diakses melalui jaringan. Pengaturan `Require all denied` pada `data/.htaccess` memerlukan Apache 2.4 dan `AllowOverride` yang mengizinkan `.htaccess`.

## Bentuk data

Data pesan dan catatan pembatasan kirim berada di `data/tamu.json` dan `data/batas-kirim.json`. File-file ini tidak boleh diakses langsung melalui web. Ekspor CSV hanya tersedia setelah autentikasi admin.