<?php

declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();

$pdo = getConnection();
$kata = trim((string) ($_GET['q'] ?? ''));
$perHalaman = 10;
$total = hitungPendaftar($pdo, $kata);
$jumlahHalaman = max(1, (int) ceil($total / $perHalaman));
$halaman = min($jumlahHalaman, max(1, (int) ($_GET['hal'] ?? 1)));
$offset = ($halaman - 1) * $perHalaman;
$daftar = ambilPendaftar($pdo, $kata, $perHalaman, $offset);

$judul = 'Daftar Pendaftar';
require __DIR__ . '/../templates/header.php';
?>

<div class='d-flex justify-content-between align-items-center mb-3'>
    <h2 class='h4 mb-0'>Daftar Pendaftar</h2>
</div>

<form method='get' class='row g-2 mb-3'>
    <div class='col-md-8'>
        <input type='text' name='q' class='form-control' value='<?= e($kata) ?>' placeholder='Cari nama, email, atau HP'>
    </div>
    <div class='col-md-4'>
        <button type='submit' class='btn btn-outline-primary w-100'>Cari</button>
    </div>
</form>

<?php if ($daftar === []): ?>
    <p class='text-muted'>Tidak ada data.</p>
<?php else: ?>
    <div class='table-responsive'>
        <table id='tabelPendaftar' class='table table-striped align-middle'>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daftar as $p): ?>
                    <tr>
                        <td><?= e($p['nama']) ?></td>
                        <td><?= e($p['email']) ?></td>
                        <td><?= e($p['no_hp']) ?></td>
                        <td><?= e($p['nama_kelas']) ?></td>
                        <td>
                            <a class='btn btn-sm btn-outline-secondary' href='ubah.php?id=<?= (int) $p['id'] ?>'>Ubah</a>
                            <a class='btn btn-sm btn-outline-primary' href='cetak.php?id=<?= (int) $p['id'] ?>' target='_blank' rel='noopener'>Cetak</a>
                            <form method='post' action='hapus.php' class='form-hapus d-inline' data-nama='<?= e($p['nama']) ?>'>
                                <input type='hidden' name='csrf' value='<?= e(tokenCsrf()) ?>'>
                                <input type='hidden' name='id' value='<?= (int) $p['id'] ?>'>
                                <button class='btn btn-sm btn-outline-danger' type='submit'>Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav aria-label='Pagination'>
        <ul class='pagination'>
            <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
                <li class='page-item <?= $i === $halaman ? 'active' : '' ?>'>
                    <a class='page-link' href='admin.php?q=<?= e(urlencode($kata)) ?>&hal=<?= (int) $i ?>'><?= (int) $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>

<?php require __DIR__ . '/../templates/footer.php'; ?>