
## Informasi Sistem

- **Sistem operasi dan versi:** Microsoft Windows 10 Pro 10.0.19045 N/A Build 19045
- **Arsitektur (32/64-bit):** 64-bit
- **RAM total:** 7.876 MB
- **Ruang disk kosong:** 1.011 MB
- **Hak akses (admin/standar):** Standar

![bukti KUK 1.1](img/Screenshot%202026-10-19%20193656.png)

## Kebutuhan proyek

1. Menginstal dan menjalankan server lokal.
2. Membuat dan mengelola database.
3. Menulis dan menjalankan kode PHP.
4. Mengelola file dan folder proyek.
5. Menguji aplikasi web di browser.

## Matriks pemilihan tools (KUK 1.2)

1. Kesesuaian OS (5): Mendukung Windows 10 64-bit.
2. Kemudahan instalasi dan pemakaian (5): Instalasi relatif mudah dan tersedia Control Panel untuk menjalankan Apache dan MySQL/MariaDB.
3. Kebutuhan sumber daya (4): Membutuhkan sumber daya komputer untuk menjalankan layanan server lokal.
4. Dokumentasi/komunitas (5): Memiliki dokumentasi dan banyak tutorial yang tersedia di internet.
5. Lisensi dan unduhan resmi (4): Tersedia secara resmi dan dapat digunakan tanpa biaya untuk kebutuhan umum, dengan tetap memperhatikan ketentuan lisensinya.

## Langkah instalasi per tools (versi, lokasi, opsi)  dan kendala yang dialami beserta solusinya (KUK 2.1). 

A.Instalasi dan Konfigurasi VS Code 
1. Unduh VS Code dari situs resmi, pasang dengan opsi Add to PATH dan Open with Code. 
2. Pasang ekstensi: Live Server, PHP Intelephense, Prettier, ESLint, Material Icon Theme 
(opsional). 
3. Atur Settings: Format On Save aktif, Tab Size 2 (HTML/CSS/JS) dan 4 (PHP), Auto Save aktif. 
4. Buat folder portofolio-junior-web/hari-01-instalasi/, buka dengan File > Open 
Folder. 
5. Buat index.html, ketik ! lalu Tab (Emmet) untuk kerangka HTML, ubah isi, klik kanan > Open 
with Live Server. 
6. Verifikasi dari terminal: code --version. 

versi vs code :
lokasi : C:\Users\muhsa\AppData\Roaming\Microsoft\Windows\Start Menu\Programs
tidak ada kendala instal

B. Instalasi Server Lokal (XAMPP atau Laragon) 
XAMPP: 
1. Unduh installer dari situs resmi Apache Friends sesuai OS dan versi PHP 8.x. 
2. Jalankan installer, centang minimal Apache, MySQL, PHP, phpMyAdmin; folder tujuan C:\xampp. 
3. Buka XAMPP Control Panel, klik Start pada Apache dan MySQL hingga hijau. 
4. Uji http://localhost dan http://localhost/phpmyadmin. 
Laragon: unduh edisi Full, pasang ke C:\laragon, klik Start All, uji http://localhost. Root dokumen: 
C:\laragon\www.

versi XAMPP : v3.3.0
lokasi : C:\xampp
tidak ada kendala instal

C.  Node.js, Composer, dan Git 
1. Pasang Node.js LTS (opsi Add to PATH), Composer (arahkan ke php.exe XAMPP/Laragon), dan 
Git. 
2. Tambahkan PHP ke PATH bila perintah php tidak dikenali: Environment Variables > Path > New, isi 
C:\xampp\php, buka ulang terminal. 
3. Verifikasi seluruhnya: 
php -v 
node -v 
npm -v 
composer -V 
git --version 
4. Atur identitas Git: 
git config --global user.name 'Nama Peserta' 
git config --global user.email 'email@contoh.com' 
git config --global init.defaultBranch main 
git config --list 

versi PHP : PHP 8.4.25   | lokasi 
versi node js : v24.14.1
versi npm : 11.11.0
versi composer : Composer version 2.10.3
versi git : git version 2.53.0.windows.2

tidak ada kendala instal



## Hasil Pemeriksaan Versi Tools

| PHP | `php -v` | PHP 8.4.25 | ✅ Done |
| Node.js | `node -v` | v24.14.1 | ✅ Done |
| npm | `npm -v` | 11.11.0 | ✅ Done |
| Composer | `composer -V` | Composer version 2.10.3 | ✅ Done |
| Git | `git --version` | git version 2.53.0.windows.2 | ✅ Done |

![Tabel verifikasi (screenshot untuk bukti KUK 2.2)](img/Tabel%20verifikasi1.png)
![Tabel verifikasi 2 (screenshot untuk bukti KUK 2.2)](img/Tabel%20verifikasi2.png)