<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/pendaftar.php';
require_once __DIR__ . '/../src/kelas.php';

final class TestPdo extends PDO
{
    private bool $aktif = false;
    private int $jumlahCommit = 0;
    private int $jumlahRollback = 0;

    public function __construct(private Closure $penjawab)
    {
    }

    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        return new TestPdoStatement($this, $query);
    }

    public function query(string $query, ?int $fetchMode = null, mixed ...$fetchModeArgs): PDOStatement|false
    {
        $stmt = new TestPdoStatement($this, $query);
        $stmt->execute();
        return $stmt;
    }

    public function jawab(string $query, array $params): array
    {
        return ($this->penjawab)($query, $params);
    }

    public function beginTransaction(): bool
    {
        $this->aktif = true;
        return true;
    }

    public function commit(): bool
    {
        $this->aktif = false;
        $this->jumlahCommit++;
        return true;
    }

    public function rollBack(): bool
    {
        $this->aktif = false;
        $this->jumlahRollback++;
        return true;
    }

    public function inTransaction(): bool
    {
        return $this->aktif;
    }

    public function jumlahCommit(): int
    {
        return $this->jumlahCommit;
    }

    public function jumlahRollback(): int
    {
        return $this->jumlahRollback;
    }
}

final class TestPdoStatement extends PDOStatement
{
    private array $parameterTerikat = [];
    private array $baris = [];
    private mixed $nilai = false;
    private int $jumlahBaris = 1;
    private int $posisi = 0;

    public function __construct(
        private TestPdo $pdo,
        private string $sql
    ) {
    }

    public function execute(?array $params = null): bool
    {
        $jawaban = $this->pdo->jawab($this->sql, $params ?? $this->parameterTerikat);
        $this->baris = $jawaban['baris'] ?? [];
        $this->nilai = $jawaban['nilai'] ?? false;
        $this->jumlahBaris = $jawaban['jumlah_baris'] ?? 1;
        $this->posisi = 0;
        return true;
    }

    public function bindValue(string|int $param, mixed $value, int $type = PDO::PARAM_STR): bool
    {
        $this->parameterTerikat[ltrim((string) $param, ':')] = $value;
        return true;
    }

    public function fetch(
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): mixed {
        return $this->baris[$this->posisi++] ?? false;
    }

    public function fetchAll(int $mode = PDO::FETCH_DEFAULT, mixed ...$args): array
    {
        return $this->baris;
    }

    public function fetchColumn(int $column = 0): mixed
    {
        if ($this->nilai !== false) {
            return $this->nilai;
        }
        $baris = $this->baris[0] ?? [];
        return array_values($baris)[$column] ?? false;
    }

    public function rowCount(): int
    {
        return $this->jumlahBaris;
    }
}

$jumlahGagal = 0;
$jumlahUji = 0;

function uji(string $nama, bool $berhasil): void
{
    global $jumlahGagal, $jumlahUji;
    $jumlahUji++;
    if (!$berhasil) {
        $jumlahGagal++;
    }
    echo ($berhasil ? '[LOLOS] ' : '[GAGAL] ') . $nama . PHP_EOL;
}

function pdoValidasi(bool $emailAda = false): TestPdo
{
    return new TestPdo(static function (string $sql) use ($emailAda): array {
        if (str_contains($sql, 'email = :email')) {
            return ['nilai' => $emailAda ? 1 : 0];
        }
        if (str_contains($sql, 'FROM kelas k')) {
            return ['baris' => [[
                'id' => '1',
                'nama_kelas' => 'Web Programming',
                'kuota' => '30',
                'jumlah_pendaftar' => '4',
            ]]];
        }
        if (str_contains($sql, 'nama_kelas = :nama')) {
            return ['nilai' => 0];
        }
        return [];
    });
}

$_SESSION = [];
uji('HTML di-escape sebelum ditampilkan', e('<script>') === '&lt;script&gt;');
uji('Token CSRF memiliki 64 karakter heksadesimal', preg_match('/^[a-f0-9]{64}$/', tokenCsrf()) === 1);

$dataPendaftar = [
    'nama' => 'Sari Pelatihan',
    'email' => 'SARI@example.test',
    'no_hp' => '0812345678',
    'alamat' => 'Surakarta',
    'kelas_id' => '1',
];
$hasilValid = validasiPendaftar($dataPendaftar, pdoValidasi(), null);
uji('Pendaftar valid diterima dan email dinormalisasi', $hasilValid['galat'] === []
    && $hasilValid['data']['email'] === 'sari@example.test');
uji('ID kelas string dari formulir cocok dengan ID database', $hasilValid['galat'] === []);

$hasilHpPendek = validasiPendaftar(
    array_replace($dataPendaftar, ['no_hp' => '081234567']),
    pdoValidasi(),
    null
);
uji('Nomor HP terlalu pendek ditolak', isset($hasilHpPendek['galat']['no_hp']));

$hasilEmailGanda = validasiPendaftar($dataPendaftar, pdoValidasi(true), null);
uji('Email yang sudah digunakan ditolak', isset($hasilEmailGanda['galat']['email']));

$hasilIdKelas = validasiPendaftar(
    array_replace($dataPendaftar, ['kelas_id' => '1x']),
    pdoValidasi(),
    null
);
uji('ID kelas dengan karakter tambahan ditolak', isset($hasilIdKelas['galat']['kelas_id']));

$pdoKelas = new TestPdo(static function (string $sql): array {
    return str_contains($sql, 'nama_kelas = :nama') ? ['nilai' => 0] : [];
});
$hasilKelas = validasiKelas(['nama_kelas' => 'Web Lanjutan', 'kuota' => '12'], $pdoKelas);
uji('Data kelas dengan kuota valid diterima', $hasilKelas['galat'] === []);

$hasilKuotaNegatif = validasiKelas(['nama_kelas' => 'Web Lanjutan', 'kuota' => '-1'], $pdoKelas);
uji('Kuota negatif ditolak', isset($hasilKuotaNegatif['galat']['kuota']));

$pdoKuotaPenuh = new TestPdo(static function (string $sql): array {
    if (str_contains($sql, 'SELECT id FROM pendaftar')) {
        return ['nilai' => 7];
    }
    if (str_contains($sql, 'SELECT kuota FROM kelas')) {
        return ['nilai' => 2];
    }
    if (str_contains($sql, 'COUNT(*) FROM pendaftar WHERE kelas_id')) {
        return ['nilai' => 2];
    }
    return [];
});
$melemparKuotaPenuh = false;
try {
    ubahPendaftar($pdoKuotaPenuh, 7, [
        'nama' => 'Sari Pelatihan',
        'email' => 'sari@example.test',
        'no_hp' => '0812345678',
        'alamat' => 'Surakarta',
        'kelas_id' => 2,
    ]);
} catch (KuotaPenuhException) {
    $melemparKuotaPenuh = true;
}
uji('Perubahan peserta ditolak jika kelas penuh', $melemparKuotaPenuh);
uji('Transaksi perubahan peserta yang gagal dibatalkan', $pdoKuotaPenuh->jumlahRollback() === 1);

$pdoRingkasan = new TestPdo(static fn (string $sql): array => [
    'baris' => [
        ['nama_kelas' => 'Desain Grafis', 'jumlah_pendaftar' => 2],
        ['nama_kelas' => 'Web Programming', 'jumlah_pendaftar' => 5],
    ],
]);
$ringkasan = ringkasanPendaftarPerKelas($pdoRingkasan);
uji('Pemeringkatan kelas diurutkan dari jumlah pendaftar terbanyak', $ringkasan[0]['nama_kelas'] === 'Web Programming');

echo PHP_EOL . ($jumlahGagal === 0
    ? "Semua {$jumlahUji} uji lolos."
    : "{$jumlahGagal} dari {$jumlahUji} uji gagal.") . PHP_EOL;
exit($jumlahGagal === 0 ? 0 : 1);
