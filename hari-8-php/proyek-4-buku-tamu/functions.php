<?php

declare(strict_types=1);

const FILE_TAMU = __DIR__ . '/data/tamu.json';
const FILE_BATAS_KIRIM = __DIR__ . '/data/batas-kirim.json';
const MAKS_PESAN = 500;
const PESAN_PER_HALAMAN = 5;
const JEDA_KIRIM_DETIK = 30;

/**
 * Meng-escape teks untuk konteks HTML.
 *
 * @param string $teks Teks yang akan ditampilkan.
 * @return string Teks aman untuk HTML.
 */
function e(string $teks): string
{
    return htmlspecialchars($teks, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Merapikan spasi berulang pada nama.
 *
 * @param string $teks Teks masukan.
 * @return string Teks tanpa spasi berlebih.
 */
function bersihkanSpasi(string $teks): string
{
    return trim((string) preg_replace('/\s+/', ' ', $teks));
}

/**
 * Memvalidasi input buku tamu dan mengembalikan data lama bersama pesan per kolom.
 *
 * @param array<string, mixed> $input Data mentah, biasanya $_POST.
 * @return array{data: array{nama: string, email: string, pesan: string}, galat: array<string, string>}
 */
function validasiTamu(array $input): array
{
    $data = [
        'nama' => is_string($input['nama'] ?? null) ? bersihkanSpasi($input['nama']) : '',
        'email' => is_string($input['email'] ?? null) ? trim($input['email']) : '',
        'pesan' => is_string($input['pesan'] ?? null) ? trim($input['pesan']) : '',
    ];
    $galat = [];

    if (mb_strlen($data['nama']) < 3) {
        $galat['nama'] = 'Nama minimal 3 karakter.';
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $galat['email'] = 'Format email tidak valid.';
    }

    $panjangPesan = mb_strlen($data['pesan']);
    if ($panjangPesan === 0 || $panjangPesan > MAKS_PESAN) {
        $galat['pesan'] = 'Pesan wajib diisi, maksimal ' . MAKS_PESAN . ' karakter.';
    }

    return ['data' => $data, 'galat' => $galat];
}

/**
 * Membaca daftar tamu dari JSON dan memastikan bentuk datanya benar.
 *
 * @param string $json Isi berkas JSON.
 * @return list<array{id: int, nama: string, email: string, pesan: string, waktu: string}>
 */
function uraikanDaftarTamu(string $json): array
{
    if (trim($json) === '') {
        return [];
    }

    try {
        $daftar = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $error) {
        throw new RuntimeException('Berkas data tamu bukan JSON yang valid.', 0, $error);
    }

    if (
        !is_array($daftar)
        || ($daftar !== [] && array_keys($daftar) !== range(0, count($daftar) - 1))
    ) {
        throw new RuntimeException('Struktur berkas data tamu tidak valid.');
    }

    foreach ($daftar as $tamu) {
        if (
            !is_array($tamu)
            || !is_int($tamu['id'] ?? null)
            || !is_string($tamu['nama'] ?? null)
            || !is_string($tamu['email'] ?? null)
            || !is_string($tamu['pesan'] ?? null)
            || !is_string($tamu['waktu'] ?? null)
        ) {
            throw new RuntimeException('Format salah satu data tamu tidak valid.');
        }
    }

    return $daftar;
}

/**
 * Memastikan folder data tersedia.
 *
 * @return void
 */
function siapkanFolderData(): void
{
    $folder = dirname(FILE_TAMU);
    if (!is_dir($folder) && !mkdir($folder, 0755, true) && !is_dir($folder)) {
        throw new RuntimeException('Folder data buku tamu tidak dapat dibuat.');
    }
}

/**
 * Membaca daftar tamu dengan kunci bersama agar tidak membaca saat berkas ditulis.
 *
 * @return list<array{id: int, nama: string, email: string, pesan: string, waktu: string}>
 */
function ambilSemuaTamu(): array
{
    if (!file_exists(FILE_TAMU)) {
        return [];
    }

    $handle = fopen(FILE_TAMU, 'rb');
    if ($handle === false) {
        throw new RuntimeException('Berkas data tamu tidak dapat dibuka.');
    }

    try {
        if (!flock($handle, LOCK_SH)) {
            throw new RuntimeException('Berkas data tamu tidak dapat dikunci untuk dibaca.');
        }
        $isi = stream_get_contents($handle);
        if ($isi === false) {
            throw new RuntimeException('Berkas data tamu tidak dapat dibaca.');
        }
        return uraikanDaftarTamu($isi);
    } finally {
        flock($handle, LOCK_UN);
        fclose($handle);
    }
}

/**
 * Menulis seluruh isi berkas yang sudah dikunci.
 *
 * @param resource $handle Handle berkas yang sedang dikunci.
 * @param string $isi Isi baru.
 * @return void
 */
function tulisBerkasTerkunci($handle, string $isi): void
{
    if (!rewind($handle) || !ftruncate($handle, 0)) {
        throw new RuntimeException('Berkas data tidak dapat diperbarui.');
    }

    $tertulis = 0;
    $panjang = strlen($isi);
    while ($tertulis < $panjang) {
        $jumlah = fwrite($handle, substr($isi, $tertulis));
        if ($jumlah === false || $jumlah === 0) {
            throw new RuntimeException('Berkas data tidak dapat ditulis.');
        }
        $tertulis += $jumlah;
    }

    if (!fflush($handle)) {
        throw new RuntimeException('Perubahan berkas data tidak dapat disimpan.');
    }
}

/**
 * Menyimpan tamu baru dan mengembalikan nomor detik tunggu bila IP masih dibatasi.
 *
 * @param array{nama: string, email: string, pesan: string} $data Data tamu tervalidasi.
 * @param string $ip Alamat IP dari koneksi.
 * @return int Sisa waktu tunggu; nol berarti berhasil tersimpan.
 */
function simpanTamu(array $data, string $ip): int
{
    siapkanFolderData();

    $handleBatas = fopen(FILE_BATAS_KIRIM, 'c+');
    if ($handleBatas === false) {
        throw new RuntimeException('Berkas pembatasan kirim tidak dapat dibuka.');
    }

    try {
        if (!flock($handleBatas, LOCK_EX)) {
            throw new RuntimeException('Berkas pembatasan kirim tidak dapat dikunci.');
        }

        $isiBatas = stream_get_contents($handleBatas);
        if ($isiBatas === false) {
            throw new RuntimeException('Berkas pembatasan kirim tidak dapat dibaca.');
        }
        try {
            $batas = trim($isiBatas) === ''
                ? []
                : json_decode($isiBatas, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $error) {
            throw new RuntimeException('Berkas pembatasan kirim bukan JSON yang valid.', 0, $error);
        }
        if (!is_array($batas)) {
            throw new RuntimeException('Struktur berkas pembatasan kirim tidak valid.');
        }

        $kunciIp = hash('sha256', $ip);
        $waktuSekarang = time();
        $waktuTerakhir = $batas[$kunciIp] ?? null;
        if (is_int($waktuTerakhir) && $waktuSekarang - $waktuTerakhir < JEDA_KIRIM_DETIK) {
            return JEDA_KIRIM_DETIK - ($waktuSekarang - $waktuTerakhir);
        }

        $handleTamu = fopen(FILE_TAMU, 'c+');
        if ($handleTamu === false) {
            throw new RuntimeException('Berkas data tamu tidak dapat dibuka.');
        }

        try {
            if (!flock($handleTamu, LOCK_EX)) {
                throw new RuntimeException('Berkas data tamu tidak dapat dikunci untuk ditulis.');
            }
            $isiTamu = stream_get_contents($handleTamu);
            if ($isiTamu === false) {
                throw new RuntimeException('Berkas data tamu tidak dapat dibaca.');
            }

            $daftar = uraikanDaftarTamu($isiTamu);
            $idBerikutnya = $daftar === [] ? 1 : max(array_column($daftar, 'id')) + 1;
            $daftar[] = [
                'id' => $idBerikutnya,
                'nama' => $data['nama'],
                'email' => $data['email'],
                'pesan' => $data['pesan'],
                'waktu' => date('Y-m-d H:i:s'),
            ];
            try {
                $jsonTamu = json_encode($daftar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
            } catch (JsonException $error) {
                throw new RuntimeException('Data tamu tidak dapat diubah menjadi JSON.', 0, $error);
            }
            tulisBerkasTerkunci($handleTamu, $jsonTamu . PHP_EOL);
        } finally {
            flock($handleTamu, LOCK_UN);
            fclose($handleTamu);
        }

        $batas[$kunciIp] = $waktuSekarang;
        foreach ($batas as $kunci => $waktu) {
            if (!is_int($waktu) || $waktu < $waktuSekarang - 86400) {
                unset($batas[$kunci]);
            }
        }
        try {
            $jsonBatas = json_encode($batas, JSON_THROW_ON_ERROR);
        } catch (JsonException $error) {
            throw new RuntimeException('Data pembatasan kirim tidak dapat diubah menjadi JSON.', 0, $error);
        }
        tulisBerkasTerkunci($handleBatas, $jsonBatas . PHP_EOL);

        return 0;
    } finally {
        flock($handleBatas, LOCK_UN);
        fclose($handleBatas);
    }
}

/**
 * Mencari pesan berdasarkan nama tanpa membedakan huruf besar dan kecil.
 *
 * @param list<array{id: int, nama: string, email: string, pesan: string, waktu: string}> $daftar Daftar tamu.
 * @param string $kata Kata pencarian.
 * @return list<array{id: int, nama: string, email: string, pesan: string, waktu: string}> Hasil pencarian.
 */
function cariTamu(array $daftar, string $kata): array
{
    if ($kata === '') {
        return $daftar;
    }

    return array_values(array_filter(
        $daftar,
        static fn(array $tamu): bool => stripos($tamu['nama'], $kata) !== false
    ));
}

/**
 * Menghapus pesan berdasarkan ID.
 *
 * @param int $id ID pesan yang akan dihapus.
 * @return bool True jika pesan ditemukan dan dihapus.
 */
function hapusTamu(int $id): bool
{
    if (!file_exists(FILE_TAMU)) {
        return false;
    }

    $handle = fopen(FILE_TAMU, 'c+');
    if ($handle === false) {
        throw new RuntimeException('Berkas data tamu tidak dapat dibuka.');
    }

    try {
        if (!flock($handle, LOCK_EX)) {
            throw new RuntimeException('Berkas data tamu tidak dapat dikunci untuk diubah.');
        }
        $isi = stream_get_contents($handle);
        if ($isi === false) {
            throw new RuntimeException('Berkas data tamu tidak dapat dibaca.');
        }

        $daftar = uraikanDaftarTamu($isi);
        $daftarBaru = array_values(array_filter(
            $daftar,
            static fn(array $tamu): bool => $tamu['id'] !== $id
        ));
        if (count($daftarBaru) === count($daftar)) {
            return false;
        }

        try {
            $json = json_encode($daftarBaru, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        } catch (JsonException $error) {
            throw new RuntimeException('Data tamu tidak dapat diubah menjadi JSON.', 0, $error);
        }
        tulisBerkasTerkunci($handle, $json . PHP_EOL);
        return true;
    } finally {
        flock($handle, LOCK_UN);
        fclose($handle);
    }
}

/**
 * Memastikan password admin diatur dan memvalidasi HTTP Basic Authentication.
 *
 * @return void
 */
function wajibkanAdmin(): void
{
    $passwordBenar = getenv('BUKU_TAMU_ADMIN_PASSWORD');
    if ($passwordBenar === false || $passwordBenar === '') {
        http_response_code(503);
        exit('Admin belum dikonfigurasi. Atur BUKU_TAMU_ADMIN_PASSWORD pada server.');
    }

    $passwordMasuk = $_SERVER['PHP_AUTH_PW'] ?? '';
    if (!is_string($passwordMasuk) || !hash_equals($passwordBenar, $passwordMasuk)) {
        header('WWW-Authenticate: Basic realm="Admin Buku Tamu"');
        http_response_code(401);
        exit('Autentikasi admin diperlukan.');
    }
}

/**
 * Membuat atau mengambil token CSRF untuk sesi admin.
 *
 * @return string Token sesi.
 */
function tokenCsrfAdmin(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_set_cookie_params([
            'httponly' => true,
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'samesite' => 'Strict',
        ]);
        session_start();
    }

    if (!isset($_SESSION['token_csrf']) || !is_string($_SESSION['token_csrf'])) {
        $_SESSION['token_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['token_csrf'];
}

/**
 * Menulis seluruh pesan ke keluaran CSV dan menetralkan rumus spreadsheet.
 *
 * @param list<array{id: int, nama: string, email: string, pesan: string, waktu: string}> $daftar Daftar tamu.
 * @return void
 */
function eksporCsvTamu(array $daftar): void
{
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="buku-tamu.csv"');
    echo "\xEF\xBB\xBF";

    $keluaran = fopen('php://output', 'wb');
    if ($keluaran === false) {
        throw new RuntimeException('Keluaran CSV tidak dapat dibuka.');
    }

    fputcsv($keluaran, ['ID', 'Nama', 'Email', 'Pesan', 'Waktu'], ',', '"', '');
    foreach ($daftar as $tamu) {
        $baris = array_map(
            static function (string $nilai): string {
                return preg_match('/^[\t\r ]*[=+\-@]/', $nilai) === 1 ? "'" . $nilai : $nilai;
            },
            [
                (string) $tamu['id'],
                $tamu['nama'],
                $tamu['email'],
                $tamu['pesan'],
                $tamu['waktu'],
            ]
        );
        fputcsv($keluaran, $baris, ',', '"', '');
    }
    fclose($keluaran);
}
