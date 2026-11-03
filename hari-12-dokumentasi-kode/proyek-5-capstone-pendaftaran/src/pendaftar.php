<?php

declare(strict_types=1);
/**
 * mengambil daftar kelas dari database.
 * 
 * @param PDO $pdo Koneksi database aktif.
 * @return array<int, array<string, mixed>> Daftar kelas.   
 * 
 */
function daftarKelas(PDO $pdo): array
{
    return $pdo->query('SELECT id, nama_kelas FROM kelas ORDER BY 
nama_kelas')->fetchAll();
}

/**
 * Menghitung jumlah pendaftar berdasarkan kata kunci.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param string $kata Kata kunci pencarian.
 * @return int Jumlah pendaftar.
 */
function hitungPendaftar(PDO $pdo, string $kata): int
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE nama LIKE :kata');
    $stmt->execute(['kata' => '%' . $kata . '%']);
    return (int) $stmt->fetchColumn();
}

/**
 * Mengambil daftar pendaftar berdasarkan kata kunci, batas, dan offset.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param string $kata Kata kunci pencarian.
 * @param int $batas Batas jumlah pendaftar yang diambil.
 * @param int $offset Offset untuk pengambilan pendaftar.
 * @return array<int, array<string, mixed>> Daftar pendaftar.
 */
function ambilPendaftar(PDO $pdo, string $kata, int $batas, int $offset): array
{
    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, k.nama_kelas 
 
            FROM pendaftar p JOIN kelas k ON k.id = p.kelas_id 
            WHERE p.nama LIKE :kata 
            ORDER BY p.id DESC LIMIT :batas OFFSET :offset';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':kata', '%' . $kata . '%');
    $stmt->bindValue(':batas', $batas, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Mengambil satu pendaftar berdasarkan ID.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param int $id  ID pendaftar (minimal 1).
 *
 * @return array<string, mixed>|null Baris pendaftar, atau null bila tidak ditemukan.
 */
function ambilPendaftarById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM pendaftar WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $baris = $stmt->fetch();
    return $baris === false ? null : $baris;
}

/**
 * Memeriksa apakah email sudah terdaftar.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param string $email Email yang akan diperiksa.
 * @param int|null $kecualiId ID pendaftar yang dikecualikan (untuk edit).
 * @return bool true bila email sudah terdaftar, false sebaliknya.
 */
function emailSudahAda(PDO $pdo, string $email, ?int $kecualiId): bool
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE email = :email AND id 
<> :id');
    $stmt->execute(['email' => $email, 'id' => $kecualiId ?? 0]);
    return (int) $stmt->fetchColumn() > 0;
}

/**
 * Memvalidasi masukan form pendaftar dan mengembalikan data bersih serta galat.
 *
 * @param array<string, mixed> $input   Data mentah (biasanya $_POST).
 * @param PDO                  $pdo     Koneksi untuk memeriksa email ganda dan kelas.
 * @param int|null             $idUbah  ID pendaftar yang sedang diubah, null saat menambah.
 *
 * @return array{data: array<string, mixed>, galat: array<string, string>}
 *         `galat` kosong bila seluruh masukan valid.
 */

function validasiPendaftar(array $input, PDO $pdo, ?int $idUbah): array
{
    $data = [
        'nama' => trim((string) ($input['nama'] ?? '')),
        'email' => strtolower(trim((string) ($input['email'] ?? ''))),
        'no_hp' => trim((string) ($input['no_hp'] ?? '')),
        'alamat' => trim((string) ($input['alamat'] ?? '')),
        'kelas_id' => (int) ($input['kelas_id'] ?? 0),
    ];
    $galat = [];

    if (mb_strlen($data['nama']) < 3) {
        $galat['nama'] = 'Nama minimal 3 karakter.';
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $galat['email'] = 'Format email tidak valid.';
    } elseif (emailSudahAda($pdo, $data['email'], $idUbah)) {
        $galat['email'] = 'Email sudah terdaftar.';
    }
    if (!preg_match('/^08[0-9]{8,11}$/', $data['no_hp'])) {
        $galat['no_hp'] = 'Nomor HP diawali 08 dan 10-13 digit.';
    }
    if (!in_array($data['kelas_id'], array_column(daftarKelas($pdo), 'id'), true)) {
        $galat['kelas_id'] = 'Pilih kelas yang tersedia.';
    }

    return ['data' => $data, 'galat' => $galat];
}

/**
 * Menambahkan pendaftar baru ke database.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param array $d Data pendaftar.
 * @return bool true bila berhasil, false sebaliknya.
 */
function tambahPendaftar(PDO $pdo, array $d): bool
{
    $sql = 'INSERT INTO pendaftar (nama, email, no_hp, alamat, kelas_id) 
VALUES (:nama, :email, :no_hp, :alamat, :kelas_id)';
    return $pdo->prepare($sql)->execute($d);
}
function ubahPendaftar(PDO $pdo, int $id, array $d): bool
{
    $sql = 'UPDATE pendaftar SET nama = :nama, email = :email, no_hp = :no_hp, 
alamat = :alamat, kelas_id = :kelas_id WHERE id = :id';
    return $pdo->prepare($sql)->execute($d + ['id' => $id]);
}
function hapusPendaftar(PDO $pdo, int $id): bool
{
    return $pdo->prepare('DELETE FROM pendaftar WHERE id = :id')->execute(['id' =>
    $id]);
}

function ambilAdminById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM admin WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $baris = $stmt->fetch();
    return $baris === false ? null : $baris;
}

function ambilSemuaPendaftar(PDO $pdo, string $kata = '', int $batas = 0, int $offset = 0): array
{
    $where = '';
    $params = [];

    if ($kata !== '') {
        $where = ' WHERE p.nama LIKE :kata OR p.email LIKE :kata OR p.no_hp LIKE :kata';
        $params['kata'] = '%' . $kata . '%';
    }

    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, p.tgl_daftar, k.nama_kelas
            FROM pendaftar p
            JOIN kelas k ON k.id = p.kelas_id' . $where . '
            ORDER BY p.id DESC';

    if ($batas > 0) {
        $sql .= ' LIMIT :batas OFFSET :offset';
        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':batas', $batas, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue(':' . $key, $value);
    }
    $stmt->execute();
    return $stmt->fetchAll();
}

function ambilBuktiPendaftar(PDO $pdo, int $id): ?array
{
    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, p.tgl_daftar, k.nama_kelas 
            FROM pendaftar p JOIN kelas k ON k.id = p.kelas_id 
            WHERE p.id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $baris = $stmt->fetch();

    return $baris === false ? null : $baris;
}

final class KuotaPenuhException extends RuntimeException {}

/**
 * Menambahkan pendaftar baru ke database.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param array $d Data pendaftar.
 * @throws KuotaPenuhException Jika kuota kelas sudah penuh.
 * @return void
 */

function daftarkanDenganKuota(PDO $pdo, array $data): void
{
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('SELECT kuota FROM kelas WHERE id = :id FOR UPDATE');
        $stmt->execute(['id' => $data['kelas_id']]);
        $kuota = (int) $stmt->fetchColumn();

        $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE kelas_id = :id');
        $stmt->execute(['id' => $data['kelas_id']]);
        //kuota kelas sudah penuh, maka akan dilemparkan exception KuotaPenuhException
        if ((int) $stmt->fetchColumn() >= $kuota) {
            throw new KuotaPenuhException('Kuota kelas sudah penuh.');
        }

        tambahPendaftar($pdo, $data);
        $pdo->commit();
    } catch (Throwable $e) {  //jika terjadi kesalahan, maka transaksi akan dibatalkan dan exception dilemparkan kembali
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        throw $e;
    }
}
