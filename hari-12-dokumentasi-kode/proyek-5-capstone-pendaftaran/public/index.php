<?php

declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

$judul = 'Pendaftaran Pelatihan';
require __DIR__ . '/../templates/header.php';
?>

<div class='row align-items-center g-4'>
    <div class='col-lg-7'>
        <h2 class='mb-3'>Daftar sekarang untuk mengikuti pelatihan</h2>
        <p class='lead'>Bersiaplah untuk meningkatkan skill digital dengan kelas yang terstruktur, mentor berpengalaman, dan jadwal yang fleksibel.</p>
        <div class='d-flex gap-3 flex-wrap'>
            <a href='tambah.php' class='btn btn-primary'>Daftar Sekarang</a>
        </div>
    </div>
    <!-- <div class='col-lg-5'>
        <div class='card shadow-sm'>
            <div class='card-body'>
                <h3 class='h5'>Kelas tersedia</h3>
                <ul class='list-group list-group-flush'>
                    <?php foreach (daftarKelas(getConnection()) as $kelas): ?>
                        <li class='list-group-item d-flex justify-content-between'>
                            <span><?= e($kelas['nama_kelas']) ?></span>
                            <span class='badge text-bg-light'>Kuota <?= (int) $kelas['kuota'] ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div> -->
</div>

<?php require __DIR__ . '/../templates/footer.php'; ?>