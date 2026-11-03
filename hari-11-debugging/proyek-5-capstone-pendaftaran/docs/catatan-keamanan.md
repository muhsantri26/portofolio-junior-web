# Catatan Keamanan

## 4. Catatan keamanan: hasil uji XSS, SQL Injection, dan CSRF

Berikut adalah catatan keamanan yang dicatat setelah pengujian aplikasi pendaftaran pelatihan.

| Jenis uji | Tujuan pengujian | Contoh input | Hasil yang diharapkan | Hasil aktual | Status |
| --- | --- | --- | --- | --- | --- |
| XSS | Menilai apakah input dari pengguna bisa dieksekusi sebagai script di browser | `<script>alert('xss')</script>` | Data ditampilkan aman, tag HTML di-escape | Input diolah melalui `htmlspecialchars()` pada fungsi `e()` | Aman |
| SQL Injection | Menilai apakah query bisa dimanipulasi memakai string berbahaya | `' OR '1'='1` atau input payload SQL | Query tetap aman, parameter diproses secara terpisah | Query menggunakan `prepare()` dan bindValue / execute() | Aman |
| CSRF | Menilai apakah form bisa dipalsukan dari situs lain | Request POST tanpa token valid | Permintaan ditolak jika token salah atau tidak ada | Form menggunakan `tokenCsrf()` dan `cekCsrf()` | Aman |

## Penjelasan singkat

### 1. XSS
XSS terjadi ketika input pengguna ditampilkan ke halaman tanpa sanitasi. Pada aplikasi ini, fungsi `e()` digunakan untuk menghindari eksekusi tag HTML dan karakter berbahaya.

Contoh:
- `htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8')`
- Fungsi ini membuat karakter seperti `<`, `>`, dan `&` aman untuk ditampilkan di browser.

### 2. SQL Injection
SQL Injection terjadi ketika query dibangun dengan string mentah dan bisa dimanipulasi user. Pada aplikasi ini, semua query penting memakai prepared statement.

Contoh penerapan:
- `prepare('SELECT ... FROM admin WHERE username = :u')`
- `bindValue(':kata', '%' . $kata . '%')`
- `execute([...])`

Dengan cara ini, input user diperlakukan sebagai data, bukan sebagai perintah SQL.

### 3. CSRF
CSRF terjadi ketika pengguna yang sudah login dipaksa mengirim permintaan ke server tanpa sadar. Untuk menangkalnya, aplikasi memberi token CSRF pada setiap form yang mengubah data.

Contoh penerapan:
- `tokenCsrf()` menghasilkan token unik
- `cekCsrf()` memverifikasi token sebelum form diproses

Jika token tidak cocok, aplikasi akan menolak request dengan kode 403.

## Kesimpulan

Aplikasi ini sudah menerapkan beberapa langkah keamanan dasar yang penting:
- escaping output untuk mencegah XSS
- prepared statement untuk mencegah SQL Injection
- token CSRF untuk mencegah request palsu

Dengan langkah-langkah tersebut, sistem dinilai sudah cukup aman untuk skenario dasar dalam proyek pendaftaran pelatihan.
