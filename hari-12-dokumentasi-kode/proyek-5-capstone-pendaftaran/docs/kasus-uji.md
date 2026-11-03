# T6. Kasus Uji, Pengujian Ulang, dan Regresi

Kasus uji adalah serangkaian tes tertulis dengan data masukan dan hasil yang diharapkan.

## Teknik pengujian

| Teknik | Contoh (kolom nomor HP: 08 + 8-11 digit) |
| --- | --- |
| Partisi ekuivalen | Satu contoh valid dan satu contoh tidak valid per kelompok |
| Nilai batas | 09 digit (gagal), 10 digit (lolos), 13 digit (lolos), 14 digit (gagal) |
| Kasus negatif | Kosong, huruf, spasi, karakter khusus, `<script>` |

## Contoh skenario uji sistem

| ID | Skenario | Masukan | Hasil diharapkan | Hasil aktual | Status |
| --- | --- | --- | --- | --- | --- |
| TC-01 | Daftar valid | Data lengkap dan benar | Tersimpan, pesan sukses | Sesuai | Lolos |
| TC-02 | Email ganda | Email yang sudah ada | Ditolak dengan pesan | Sesuai | Lolos |
| TC-03 | Nomor HP valid pendek | 0812345678 | Diterima | Sesuai | Lolos |
| TC-04 | Nomor HP valid maksimal | 0812345678901 | Diterima | Sesuai | Lolos |
| TC-05 | Nomor HP terlalu pendek | 081234567 | Ditolak | Sesuai | Lolos |
| TC-06 | Nomor HP terlalu panjang | 08123456789012 | Ditolak | Sesuai | Lolos |
| TC-07 | Form kosong | Semua kolom kosong | Validasi muncul | Sesuai | Lolos |
| TC-08 | Kelas penuh | Kuota kelas sudah habis | Ditolak dengan kuota penuh | Sesuai | Lolos |
| TC-09 | Login admin benar | Username dan password sesuai | Masuk ke dashboard | Sesuai | Lolos |
| TC-10 | Login admin salah | Password salah | Login gagal | Sesuai | Lolos |
| TC-11 | Pencarian data | Kata kunci nama/email | Data relevan muncul | Sesuai | Lolos |
| TC-12 | Cetak bukti | Klik tombol cetak | File PDF dibuat | Sesuai | Lolos |
| TC-13 | Hapus data | Hapus pendaftar | Data hilang dari tabel | Sesuai | Lolos |
| TC-14 | Ubah data | Edit profil pendaftar | Update tersimpan | Sesuai | Lolos |
| TC-15 | Logout | Klik tombol logout | Session dihapus, redirect login | Sesuai | Lolos |

## Catatan

- Semua kasus uji di atas dapat dijadikan dasar untuk re-test sebelum demo proyek.
- Pengujian ulang dan regresi dilakukan untuk memastikan perubahan tidak merusak fitur yang sudah berjalan.
