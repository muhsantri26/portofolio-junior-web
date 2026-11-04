<?php

declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();

$pdo = getConnection();
$kelas = ambilSemuaKelas($pdo);
$ringkasan = ringkasanPendaftarPerKelas($pdo);
$total = hitungPendaftar($pdo, '');
$daftar = ambilSemuaPendaftar($pdo);

$judul = 'Daftar Pendaftar';
require __DIR__ . '/../templates/header.php';
?>

<h1 class="h3 mb-4">Daftar Pendaftar</h1>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <p class="mb-0">Total pendaftar: <strong><?= $total ?></strong></p>
  <a class="btn btn-primary" href="kelas.php">Kelola kelas</a>
</div>
<?php if ($ringkasan !== []): ?>
  <div class="row g-3 mb-4">
    <?php foreach (array_slice($ringkasan, 0, 5) as $item): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="h6"><?= e($item['nama_kelas']) ?></h2>
            <p class="mb-0"><?= (int) $item['jumlah_pendaftar'] ?> pendaftar</p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<div class="mb-3">
  <label class="form-label" for="filterKelas">Filter kelas</label>
  <select id="filterKelas" class="form-select" aria-label="Filter daftar berdasarkan kelas">
    <option value="">Semua kelas</option>
    <?php foreach ($kelas as $item): ?>
      <option value="<?= e($item['nama_kelas']) ?>"><?= e($item['nama_kelas']) ?></option>
    <?php endforeach; ?>
  </select>
</div>

<?php if ($daftar === []): ?>
  <p>Tidak ada data.</p>
<?php else: ?>
  <div class="table-responsive">
    <table id="tabelPendaftar" class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>No. HP</th>
          <th>Kelas</th>
          <th>Tanggal daftar</th>
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
            <td><?= e($p['tgl_daftar']) ?></td>
            <td class="text-nowrap">
              <a class="btn btn-sm btn-outline-secondary" href="ubah.php?id=<?= (int) $p['id'] ?>">Ubah</a>
              <a class="btn btn-sm btn-outline-primary" href="cetak.php?id=<?= (int) $p['id'] ?>" target="_blank" rel="noopener">Cetak</a>
              <form method="post" action="hapus.php" class="form-hapus d-inline" data-nama="<?= e($p['nama']) ?>">
                <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/../templates/footer.php'; ?>
