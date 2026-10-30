<?php

declare(strict_types=1);

require_once __DIR__ . '/functions.php';

$galat = [];
$lama = ['nama' => '', 'email' => '', 'pesan' => ''];
$kata = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
$halamanDiminta = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
$halaman = is_int($halamanDiminta) && $halamanDiminta > 0 ? $halamanDiminta : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hasil = validasiTamu($_POST);
    $lama = $hasil['data'];
    $galat = $hasil['galat'];

    if ($galat === []) {
        try {
            $sisaWaktu = simpanTamu($hasil['data'], (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
            if ($sisaWaktu > 0) {
                $galat['umum'] = 'Anda baru saja mengirim pesan. Coba lagi dalam ' . $sisaWaktu . ' detik.';
            } else {
                header('Location: index.php?status=sukses');
                exit;
            }
        } catch (RuntimeException $error) {
            error_log($error->getMessage());
            $galat['umum'] = 'Pesan gagal disimpan. Silakan coba lagi nanti.';
        }
    }
}

try {
    $semuaTamu = array_reverse(cariTamu(ambilSemuaTamu(), $kata));
} catch (RuntimeException $error) {
    error_log($error->getMessage());
    $semuaTamu = [];
    $galat['umum'] = 'Data buku tamu tidak dapat dibaca.';
}

$jumlahTamu = count($semuaTamu);
$jumlahHalaman = max(1, (int) ceil($jumlahTamu / PESAN_PER_HALAMAN));
$halaman = min($halaman, $jumlahHalaman);
$daftarTamu = array_slice($semuaTamu, ($halaman - 1) * PESAN_PER_HALAMAN, PESAN_PER_HALAMAN);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Tamu</title>
</head>

<body>
    <h1>Buku Tamu</h1>

    <?php if (($_GET['status'] ?? '') === 'sukses'): ?>
        <p role="status">Terima kasih, pesan Anda sudah tersimpan.</p>
    <?php endif; ?>
    <?php if (isset($galat['umum'])): ?>
        <p role="alert"><?= e($galat['umum']) ?></p>
    <?php endif; ?>

    <form method="post" action="index.php">
        <p>
            <label for="nama">Nama</label><br>
            <input id="nama" name="nama" value="<?= e($lama['nama']) ?>">
            <?php if (isset($galat['nama'])): ?>
                <span role="alert"><?= e($galat['nama']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="email">Email</label><br>
            <input id="email" name="email" type="email" value="<?= e($lama['email']) ?>">
            <?php if (isset($galat['email'])): ?>
                <span role="alert"><?= e($galat['email']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="pesan">Pesan</label><br>
            <textarea id="pesan" name="pesan" rows="4"><?= e($lama['pesan']) ?></textarea>
            <?php if (isset($galat['pesan'])): ?>
                <span role="alert"><?= e($galat['pesan']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Kirim</button>
    </form>

    <h2>Daftar Tamu</h2>
    <form method="get" action="index.php">
        <label for="q">Cari nama</label>
        <input id="q" name="q" value="<?= e($kata) ?>">
        <button type="submit">Cari</button>
    </form>

    <?php if ($daftarTamu === []): ?>
        <p>Belum ada data.</p>
    <?php else: ?>
        <?php foreach ($daftarTamu as $tamu): ?>
            <article>
                <h3><?= e($tamu['nama']) ?></h3>
                <p><small><?= e($tamu['waktu']) ?></small></p>
                <p><?= nl2br(e($tamu['pesan'])) ?></p>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($jumlahHalaman > 1): ?>
        <nav aria-label="Halaman daftar tamu">
            <?php if ($halaman > 1): ?>
                <a href="?<?= e(http_build_query(['q' => $kata, 'page' => $halaman - 1])) ?>">Sebelumnya</a>
            <?php endif; ?>
            <span>Halaman <?= e((string) $halaman) ?> dari <?= e((string) $jumlahHalaman) ?></span>
            <?php if ($halaman < $jumlahHalaman): ?>
                <a href="?<?= e(http_build_query(['q' => $kata, 'page' => $halaman + 1])) ?>">Berikutnya</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</body>

</html>
