<?php
if (!(isset($lama))) {
    $lama = [];
}
if (!(isset($kelas))) {
    $kelas = [];
}
?>
<div class='card'>
    <div class='card-body'>
        <form method='post' class=''>
            <input type='hidden' name='csrf' value='<?= e(tokenCsrf()) ?>'>
            <div class='mb-3'>
                <label for='nama' class='form-label'>Nama</label><br>
                <input id='nama' name='nama' class='form-control <?= isset($galat['nama']) ?
                                                                        'is-invalid' : '' ?>'
                    value='<?= e($lama['nama']) ?>'>
                <?php if (isset($galat['nama'])): ?>
                    <div class='invalid-feedback'><?= e($galat['nama']) ?></div>
                <?php endif; ?>
            </div>

            <div class='mb-3'>
                <label for='email' class='form-label'>Email</label><br>
                <input id='email' name='email' class='form-control <?= isset($galat['email']) ?
                                                                        'is-invalid' : '' ?>'
                    value='<?= e($lama['email']) ?>'>
                <?php if (isset($galat['email'])): ?>
                    <div class='invalid-feedback'><?= e($galat['email']) ?></div>
                <?php endif; ?>
            </div>

            <div class='mb-3'>
                <label for='no_hp' class='form-label'>No. HP</label><br>
                <input id='no_hp' name='no_hp' class='form-control <?= isset($galat['no_hp']) ?
                                                                        'is-invalid' : '' ?>'
                    value='<?= e($lama['no_hp']) ?>'>
                <?php if (isset($galat['no_hp'])): ?>
                    <div class='invalid-feedback'><?= e($galat['no_hp']) ?></div>
                <?php endif; ?>
            </div>

            <div class='mb-3'>
                <label for='kelas_id' class='form-label'>Kelas</label><br>

                <select id='kelas_id' name='kelas_id' class='form-control'>
                    <option value=''>-- Pilih kelas --</option>
                    <?php foreach ($kelas as $k): ?>
                        <option value='<?= (int) $k['id'] ?>' <?= (int) $lama['kelas_id'] === (int)
                                                                $k['id'] ? 'selected' : '' ?>><?= e($k['nama_kelas']) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($galat['kelas_id'])): ?><span><?= e($galat['kelas_id'])
                                                                ?></span><?php endif; ?>
            </div>
            <div class='mb-3'>
                <label for='alamat' class='form-label'>Alamat</label><br>
                <textarea id='alamat' name='alamat' rows='3' class='form-control'><?= e($lama['alamat']) ?></textarea>
            </div>
            <div class='mb-3'>
                <button type='submit' class='btn btn-primary'>Simpan</button>
                <button type='reset' class='btn btn-danger'>Reset</button>
            </div>
            <a href='index.php'>Batal</a>
        </form>
    </div>
</div>