<?php

declare(strict_types=1);

require_once __DIR__ . '/functions.php';
wajibkanAdmin();

$galat = '';
$tokenCsrf = tokenCsrfAdmin();

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $tokenMasuk = $_POST['token_csrf'] ?? null;
    $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

    if (!is_string($tokenMasuk) || !hash_equals($tokenCsrf, $tokenMasuk)) {
        http_response_code(400);
        $galat = 'Permintaan tidak valid. Muat ulang halaman admin dan coba lagi.';
    } elseif (!is_int($id) || $id < 1) {
        http_response_code(400);
        $galat = 'ID pesan tidak valid.';
    } else {
        try {
            if (hapusTamu($id)) {
                header('Location: admin.php?status=dihapus');
                exit;
            }
            $galat = 'Pesan tidak ditemukan.';
        } catch (RuntimeException $error) {
            error_log($error->getMessage());
            http_response_code(500);
            $galat = 'Pesan gagal dihapus.';
        }
    }
}

if (($_GET['export'] ?? '') === 'csv') {
    try {
        eksporCsvTamu(ambilSemuaTamu());
    } catch (RuntimeException $error) {
        error_log($error->getMessage());
        http_response_code(500);
        exit('Data gagal diekspor.');
    }
    exit;
}

$halamanDiminta = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
$halaman = is_int($halamanDiminta) && $halamanDiminta > 0 ? $halamanDiminta : 1;
try {
    $semuaTamu = array_reverse(ambilSemuaTamu());
} catch (RuntimeException $error) {
    error_log($error->getMessage());
    http_response_code(500);
    $galat = 'Data buku tamu tidak dapat dibaca.';
    $semuaTamu = [];
}

$jumlahHalaman = max(1, (int) ceil(count($semuaTamu) / PESAN_PER_HALAMAN));
$halaman = min($halaman, $jumlahHalaman);
$daftarTamu = array_slice($semuaTamu, ($halaman - 1) * PESAN_PER_HALAMAN, PESAN_PER_HALAMAN);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Buku Tamu</title>
</head>

<body>
    <h1>Admin Buku Tamu</h1>
    <p><a href="index.php">Lihat buku tamu</a> | <a href="admin.php?export=csv">Ekspor CSV</a></p>

    <?php if (($_GET['status'] ?? '') === 'dihapus'): ?>
        <p role="status">Pesan berhasil dihapus.</p>
    <?php endif; ?>
    <?php if ($galat !== ''): ?>
        <p role="alert"><?= e($galat) ?></p>
    <?php endif; ?>

    <?php if ($daftarTamu === []): ?>
        <p>Belum ada pesan.</p>
    <?php else: ?>
        <?php foreach ($daftarTamu as $tamu): ?>
            <article>
                <h2><?= e($tamu['nama']) ?></h2>
                <p>Email: <?= e($tamu['email']) ?></p>
                <p><small><?= e($tamu['waktu']) ?></small></p>
                <p><?= nl2br(e($tamu['pesan'])) ?></p>
                <form method="post" action="admin.php?page=<?= e((string) $halaman) ?>">
                    <input type="hidden" name="token_csrf" value="<?= e($tokenCsrf) ?>">
                    <input type="hidden" name="id" value="<?= e((string) $tamu['id']) ?>">
                    <button type="submit">Hapus pesan</button>
                </form>
            </article>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($jumlahHalaman > 1): ?>
        <nav aria-label="Halaman admin">
            <?php if ($halaman > 1): ?>
                <a href="?page=<?= e((string) ($halaman - 1)) ?>">Sebelumnya</a>
            <?php endif; ?>
            <span>Halaman <?= e((string) $halaman) ?> dari <?= e((string) $jumlahHalaman) ?></span>
            <?php if ($halaman < $jumlahHalaman): ?>
                <a href="?page=<?= e((string) ($halaman + 1)) ?>">Berikutnya</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</body>

</html>
