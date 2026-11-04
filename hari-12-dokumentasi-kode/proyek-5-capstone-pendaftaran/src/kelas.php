<?php

declare(strict_types=1);

function ambilSemuaKelas(PDO $pdo): array
{
    $sql = 'SELECT k.id, k.nama_kelas, k.kuota, COUNT(p.id) AS jumlah_pendaftar
            FROM kelas k
            LEFT JOIN pendaftar p ON p.kelas_id = k.id
            GROUP BY k.id, k.nama_kelas, k.kuota
            ORDER BY k.nama_kelas';
    return $pdo->query($sql)->fetchAll();
}

function ambilKelasById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT id, nama_kelas, kuota FROM kelas WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $kelas = $stmt->fetch();
    return $kelas === false ? null : $kelas;
}

/**
 * @param array<string, mixed> $input
 * @return array{data: array{nama_kelas: string, kuota: int}, galat: array<string, string>}
 */
function validasiKelas(array $input, PDO $pdo, ?int $idUbah = null): array
{
    $nama = trim((string) ($input['nama_kelas'] ?? ''));
    $nilaiKuota = filter_var($input['kuota'] ?? null, FILTER_VALIDATE_INT);
    $data = [
        'nama_kelas' => $nama,
        'kuota' => $nilaiKuota === false || $nilaiKuota === null ? -1 : $nilaiKuota,
    ];
    $galat = [];

    if (mb_strlen($nama) < 3 || mb_strlen($nama) > 100) {
        $galat['nama_kelas'] = 'Nama kelas harus terdiri dari 3–100 karakter.';
    } else {
        $stmt = $pdo->prepare(
            'SELECT COUNT(*) FROM kelas WHERE nama_kelas = :nama AND id <> :id'
        );
        $stmt->execute(['nama' => $nama, 'id' => $idUbah ?? 0]);
        if ((int) $stmt->fetchColumn() > 0) {
            $galat['nama_kelas'] = 'Nama kelas sudah digunakan.';
        }
    }

    if ($nilaiKuota === false || $nilaiKuota === null || $nilaiKuota < 0) {
        $galat['kuota'] = 'Kuota harus berupa bilangan bulat nol atau lebih.';
    }

    return ['data' => $data, 'galat' => $galat];
}

function tambahKelas(PDO $pdo, array $data): bool
{
    $stmt = $pdo->prepare('INSERT INTO kelas (nama_kelas, kuota) VALUES (:nama_kelas, :kuota)');
    return $stmt->execute($data);
}

function ubahKelas(PDO $pdo, int $id, array $data): bool
{
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('SELECT id FROM kelas WHERE id = :id FOR UPDATE');
        $stmt->execute(['id' => $id]);
        if ($stmt->fetchColumn() === false) {
            $pdo->rollBack();
            return false;
        }

        $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE kelas_id = :id');
        $stmt->execute(['id' => $id]);
        if ((int) $stmt->fetchColumn() > $data['kuota']) {
            throw new KuotaKelasTidakCukupException(
                'Kuota tidak boleh lebih kecil daripada jumlah pendaftar saat ini.'
            );
        }

        $stmt = $pdo->prepare(
            'UPDATE kelas SET nama_kelas = :nama_kelas, kuota = :kuota WHERE id = :id'
        );
        $berhasil = $stmt->execute($data + ['id' => $id]);
        $pdo->commit();
        return $berhasil;
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        throw $e;
    }
}

function hapusKelas(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare('DELETE FROM kelas WHERE id = :id');
    $stmt->execute(['id' => $id]);
    return $stmt->rowCount() > 0;
}

final class KuotaKelasTidakCukupException extends RuntimeException
{
}
