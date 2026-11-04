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
    $sql = 'SELECT k.id, k.nama_kelas, k.kuota, COUNT(p.id) AS jumlah_pendaftar
            FROM kelas k
            LEFT JOIN pendaftar p ON p.kelas_id = k.id
            GROUP BY k.id, k.nama_kelas, k.kuota
            ORDER BY k.nama_kelas';
    return $pdo->query($sql)->fetchAll();
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
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM pendaftar
         WHERE nama LIKE :nama OR email LIKE :email OR no_hp LIKE :no_hp'
    );
    $pola = '%' . $kata . '%';
    $stmt->execute(['nama' => $pola, 'email' => $pola, 'no_hp' => $pola]);
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
            WHERE p.nama LIKE :nama OR p.email LIKE :email OR p.no_hp LIKE :no_hp
            ORDER BY p.id DESC LIMIT :batas OFFSET :offset';
    $stmt = $pdo->prepare($sql);
    $pola = '%' . $kata . '%';
    $stmt->bindValue(':nama', $pola);
    $stmt->bindValue(':email', $pola);
    $stmt->bindValue(':no_hp', $pola);
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
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE email = :email AND id <> :id');
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
    $nilaiKelas = filter_var($input['kelas_id'] ?? null, FILTER_VALIDATE_INT);
    $data = [
        'nama' => trim((string) ($input['nama'] ?? '')),
        'email' => strtolower(trim((string) ($input['email'] ?? ''))),
        'no_hp' => trim((string) ($input['no_hp'] ?? '')),
        'alamat' => trim((string) ($input['alamat'] ?? '')),
        'kelas_id' => $nilaiKelas === false || $nilaiKelas === null ? 0 : $nilaiKelas,
    ];
    $galat = [];

    if (mb_strlen($data['nama']) < 3 || mb_strlen($data['nama']) > 100) {
        $galat['nama'] = 'Nama harus terdiri dari 3–100 karakter.';
    }
    if (mb_strlen($data['email']) > 120 || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $galat['email'] = 'Format email tidak valid.';
    } elseif (emailSudahAda($pdo, $data['email'], $idUbah)) {
        $galat['email'] = 'Email sudah terdaftar.';
    }
    if (!preg_match('/^08[0-9]{8,11}$/', $data['no_hp'])) {
        $galat['no_hp'] = 'Nomor HP diawali 08 dan 10-13 digit.';
    }
    $idKelasTersedia = array_map(
        static fn (array $kelas): int => (int) $kelas['id'],
        daftarKelas($pdo)
    );
    if (!in_array($data['kelas_id'], $idKelasTersedia, true)) {
        $galat['kelas_id'] = 'Pilih kelas yang tersedia.';
    }
    if (mb_strlen($data['alamat']) > 2000) {
        $galat['alamat'] = 'Alamat maksimal 2000 karakter.';
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
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('SELECT id FROM pendaftar WHERE id = :id FOR UPDATE');
        $stmt->execute(['id' => $id]);
        if ($stmt->fetchColumn() === false) {
            $pdo->rollBack();
            return false;
        }

        $stmt = $pdo->prepare('SELECT kuota FROM kelas WHERE id = :id FOR UPDATE');
        $stmt->execute(['id' => $d['kelas_id']]);
        $kuota = $stmt->fetchColumn();
        if ($kuota === false) {
            throw new InvalidArgumentException('Kelas tidak tersedia.');
        }

        $stmt = $pdo->prepare(
            'SELECT COUNT(*) FROM pendaftar WHERE kelas_id = :kelas_id AND id <> :id'
        );
        $stmt->execute(['kelas_id' => $d['kelas_id'], 'id' => $id]);
        if ((int) $stmt->fetchColumn() >= (int) $kuota) {
            throw new KuotaPenuhException('Kuota kelas sudah penuh.');
        }

        $sql = 'UPDATE pendaftar SET nama = :nama, email = :email, no_hp = :no_hp,
                alamat = :alamat, kelas_id = :kelas_id WHERE id = :id';
        $berhasil = $pdo->prepare($sql)->execute($d + ['id' => $id]);
        $pdo->commit();
        return $berhasil;
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        throw $e;
    }
}
function hapusPendaftar(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare('DELETE FROM pendaftar WHERE id = :id');
    $stmt->execute(['id' => $id]);
    return $stmt->rowCount() > 0;
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
        $where = ' WHERE (p.nama LIKE :nama OR p.email LIKE :email OR p.no_hp LIKE :no_hp)';
        $pola = '%' . $kata . '%';
        $params = ['nama' => $pola, 'email' => $pola, 'no_hp' => $pola];
    }

    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, p.tgl_daftar, p.kelas_id, k.nama_kelas
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
 * @return int ID pendaftar yang baru dibuat.
 */

function daftarkanDenganKuota(PDO $pdo, array $data): int
{
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('SELECT kuota FROM kelas WHERE id = :id FOR UPDATE');
        $stmt->execute(['id' => $data['kelas_id']]);
        $nilaiKuota = $stmt->fetchColumn();
        if ($nilaiKuota === false) {
            throw new InvalidArgumentException('Kelas tidak tersedia.');
        }
        $kuota = (int) $nilaiKuota;

        $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE kelas_id = :id');
        $stmt->execute(['id' => $data['kelas_id']]);
        //kuota kelas sudah penuh, maka akan dilemparkan exception KuotaPenuhException
        if ((int) $stmt->fetchColumn() >= $kuota) {
            throw new KuotaPenuhException('Kuota kelas sudah penuh.');
        }

        if (!tambahPendaftar($pdo, $data)) {
            throw new RuntimeException('Pendaftaran gagal disimpan.');
        }
        $idPendaftar = (int) $pdo->lastInsertId();
        if ($idPendaftar < 1) {
            throw new RuntimeException('ID pendaftaran tidak berhasil dibuat.');
        }
        $pdo->commit();
        return $idPendaftar;
    } catch (Throwable $e) {  //jika terjadi kesalahan, maka transaksi akan dibatalkan dan exception dilemparkan kembali
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        throw $e;
    }
}

/**
 * Menghitung pendaftar per kelas dan mengurutkan kelas dengan peserta terbanyak.
 *
 * @return array<int, array{nama_kelas: string, jumlah_pendaftar: int}>
 */
function ringkasanPendaftarPerKelas(PDO $pdo): array
{
    $sql = 'SELECT k.nama_kelas, COUNT(p.id) AS jumlah_pendaftar
            FROM kelas k
            LEFT JOIN pendaftar p ON p.kelas_id = k.id
            GROUP BY k.id, k.nama_kelas';
    $ringkasan = $pdo->query($sql)->fetchAll();
    usort($ringkasan, static function (array $a, array $b): int {
        $perbandinganJumlah = (int) $b['jumlah_pendaftar'] <=> (int) $a['jumlah_pendaftar'];
        return $perbandinganJumlah !== 0
            ? $perbandinganJumlah
            : strcmp((string) $a['nama_kelas'], (string) $b['nama_kelas']);
    });

    return $ringkasan;
}
