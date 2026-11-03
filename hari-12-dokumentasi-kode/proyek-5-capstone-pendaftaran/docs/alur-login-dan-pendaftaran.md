# Alur Login dan Pendaftaran

Dokumen ini menjelaskan proses login admin dan pendaftaran peserta menggunakan pseudocode sederhana.

## 1. Alur Login Admin

### Pseudocode

```text
MULAI
  Jika admin sudah login:
    Arahkan ke halaman admin
    SELESAI

  Tampilkan formulir login

  Jika formulir dikirim:
    Periksa token keamanan (CSRF)
    Baca jumlah login yang gagal

    Jika sudah gagal 5 kali atau lebih:
      Tampilkan pesan "Terlalu banyak percobaan"
    Jika belum:
      Ambil username dan kata sandi
      Cari admin berdasarkan username
      Periksa kata sandi dengan password_hash di database

      Jika username dan kata sandi benar:
        Buat ID sesi baru
        Simpan ID admin di sesi
        Hapus penghitung kegagalan login
        Simpan username di sesi
        Arahkan ke halaman admin
      Jika salah:
        Tambah penghitung kegagalan login
        Tampilkan pesan bahwa username atau kata sandi salah
SELESAI
```

## 2. Alur Pendaftaran Peserta

### Pseudocode

```text
MULAI
  Ambil daftar kelas dari database
  Siapkan formulir pendaftaran yang masih kosong
  Tampilkan formulir

  Jika formulir dikirim:
    Periksa token keamanan (CSRF)
    Rapikan dan periksa nama, email, nomor HP, dan kelas

    Jika ada data yang tidak valid:
      Tampilkan kembali formulir beserta pesan kesalahan
    Jika semua data valid:
      Mulai transaksi database
      Kunci data kelas yang dipilih
      Periksa kuota kelas dan jumlah peserta yang terdaftar

      Jika jumlah peserta sudah mencapai kuota:
        Batalkan transaksi
        Tampilkan pesan bahwa kuota kelas penuh
      Jika kuota masih tersedia:
        Simpan data pendaftar
        Selesaikan transaksi
        Tampilkan pesan pendaftaran berhasil
        Arahkan ke halaman depan
SELESAI
```
