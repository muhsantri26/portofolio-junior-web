<?php

declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();

$pdo = getConnection();
$idUbah = null;
$kelasUbah = null;
$galat = [];
$aksi = 'tambah';
$dataForm = ['nama_kelas' => '', 'kuota' => 30];

if (isset($_GET['ubah'])) {
    $nilaiId = filter_var($_GET['ubah'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($nilaiId === false) {
        http_response_code(400);
        exit('ID kelas tidak valid.');
    }
    $idUbah = $nilaiId;
    $kelasUbah = ambilKelasById($pdo, $idUbah);
    if ($kelasUbah === null) {
        http_response_code(404);
        exit('Kelas tidak ditemukan.');
    }
    $aksi = 'ubah';
    $dataForm = $kelasUbah;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cekCsrf();
    $aksi = ($_POST['aksi'] ?? '') === 'ubah' ? 'ubah' : 'tambah';
    if ($aksi === 'ubah') {
        $nilaiId = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($nilaiId === false) {
            http_response_code(400);
            exit('ID kelas tidak valid.');
        }
        $idUbah = $nilaiId;
    }

    $hasil = validasiKelas($_POST, $pdo, $idUbah);
    $dataForm = $hasil['data'];
    $galat = $hasil['galat'];

    if ($galat === []) {
        try {
            $tersimpan = $aksi === 'ubah'
                ? ubahKelas($pdo, $idUbah, $dataForm)
                : tambahKelas($pdo, $dataForm);

            if (!$tersimpan) {
                http_response_code(404);
                exit('Kelas tidak ditemukan.');
            }
            setFlash($aksi === 'ubah' ? 'Kelas berhasil diubah.' : 'Kelas berhasil ditambahkan.');
            redirect('kelas.php');
        } catch (KuotaKelasTidakCukupException $e) {
            $galat['kuota'] = $e->getMessage();
        } catch (PDOException $e) {
            if (!isDuplicateKeyError($e)) {
                throw $e;
            }
            $galat['nama_kelas'] = 'Nama kelas sudah digunakan.';
        }
    }
}

$kelas = ambilSemuaKelas($pdo);
$judul = 'Kelola Kelas';
require __DIR__ . '/../templates/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <h1 class="h3 mb-0">Kelola Kelas</h1>
  <a class="btn btn-outline-secondary" href="admin.php">Kembali ke pendaftar</a>
</div>

<div class="card mb-4">
  <div class="card-body">
    <h2 class="h5"><?= $aksi === 'ubah' ? 'Ubah kelas' : 'Tambah kelas' ?></h2>
    <form method="post" action="kelas.php<?= $aksi === 'ubah' ? '?ubah=' . (int) $idUbah : '' ?>">
      <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
      <input type="hidden" name="aksi" value="<?= e($aksi) ?>">
      <?php if ($aksi === 'ubah'): ?>
        <input type="hidden" name="id" value="<?= (int) $idUbah ?>">
      <?php endif; ?>
      <div class="row g-3">
        <div class="col-md-8">
          <label class="form-label" for="nama_kelas">Nama kelas</label>
          <input id="nama_kelas" name="nama_kelas" maxlength="100" required
                 class="form-control <?= isset($galat['nama_kelas']) ? 'is-invalid' : '' ?>"
                 value="<?= e($dataForm['nama_kelas'] ?? '') ?>">
          <?php if (isset($galat['nama_kelas'])): ?>
            <div class="invalid-feedback"><?= e($galat['nama_kelas']) ?></div>
          <?php endif; ?>
        </div>
        <div class="col-md-4">
          <label class="form-label" for="kuota">Kuota</label>
          <input id="kuota" name="kuota" type="number" min="0" step="1" required
                 class="form-control <?= isset($galat['kuota']) ? 'is-invalid' : '' ?>"
                 value="<?= e((string) ($dataForm['kuota'] ?? 30)) ?>">
          <?php if (isset($galat['kuota'])): ?>
            <div class="invalid-feedback"><?= e($galat['kuota']) ?></div>
          <?php endif; ?>
        </div>
      </div>
      <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary" type="submit"><?= $aksi === 'ubah' ? 'Simpan perubahan' : 'Tambah kelas' ?></button>
        <?php if ($aksi === 'ubah'): ?>
          <a class="btn btn-outline-secondary" href="kelas.php">Batal</a>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>

<?php if ($kelas === []): ?>
  <p>Belum ada kelas.</p>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr><th>Nama kelas</th><th>Kuota</th><th>Pendaftar</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($kelas as $item): ?>
          <tr>
            <td><?= e($item['nama_kelas']) ?></td>
            <td><?= (int) $item['kuota'] ?></td>
            <td><?= (int) $item['jumlah_pendaftar'] ?></td>
            <td class="text-nowrap">
              <a class="btn btn-sm btn-outline-secondary" href="kelas.php?ubah=<?= (int) $item['id'] ?>">Ubah</a>
              <form method="post" action="hapus-kelas.php" class="form-hapus d-inline" data-nama="<?= e($item['nama_kelas']) ?>">
                <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
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
