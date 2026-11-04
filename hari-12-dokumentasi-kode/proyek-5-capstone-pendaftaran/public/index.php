<?php

declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

$kelas = ambilSemuaKelas(getConnection());
$judul = 'Pendaftaran Pelatihan';
require __DIR__ . '/../templates/header.php';
?>

<div class='row align-items-center g-4'>
    <div class='col-lg-7'>
        <h2 class='mb-3'>Daftar sekarang untuk mengikuti pelatihan</h2>
        <p class='lead'>Bersiaplah untuk meningkatkan skill digital dengan kelas yang terstruktur, mentor berpengalaman, dan jadwal yang fleksibel.</p>
    </div>
    <div class='col-lg-5'>
        <div class='card shadow-sm'>
            <div class='card-body'>
                <h3 class='h5'>Kelas tersedia</h3>
                <ul class='list-group list-group-flush'>
                    <?php foreach ($kelas as $item): ?>
                        <?php $sisa = max(0, (int) $item['kuota'] - (int) $item['jumlah_pendaftar']); ?>
                        <li class='list-group-item d-flex justify-content-between'>
                            <span><?= e($item['nama_kelas']) ?></span>
                            <span class='badge text-bg-light'>Sisa kuota <?= $sisa ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class='mt-4'>
    <?php if ($kelas !== []): ?>
        <a href='tambah.php' class='btn btn-primary'>Daftar Sekarang</a>
    <?php else: ?>
        <button class='btn btn-primary' type='button' disabled>Belum ada kelas</button>
    <?php endif; ?>
    <?php if (!empty($_SESSION['bukti_pendaftar_id'])): ?>
        <a href='cetak.php?id=<?= (int) $_SESSION['bukti_pendaftar_id'] ?>'
           class='btn btn-outline-primary ms-2' target='_blank' rel='noopener'>
            Cetak bukti pendaftaran
        </a>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../templates/footer.php'; ?>