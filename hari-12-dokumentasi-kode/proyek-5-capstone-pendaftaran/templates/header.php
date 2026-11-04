<?php /* templates/header.php */ ?>
<!DOCTYPE html>
<html lang='id'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title><?= e($judul ?? 'Pendaftaran Pelatihan') ?></title>
    <link rel='stylesheet'
        href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'>
    <link rel='stylesheet'
        href='https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css'>
</head>

<body class='bg-light'>
    <nav class='navbar navbar-expand-md navbar-dark bg-primary'>
        <div class='container'>
            <a class='navbar-brand' href='index.php'>Pendaftaran Pelatihan</a>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse'
                data-bs-target='#menu' aria-controls='menu' aria-expanded='false'
                aria-label='Buka menu'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div id='menu' class='collapse navbar-collapse'>
                <ul class='navbar-nav ms-auto'>
                    <?php if (empty($_SESSION['admin_id'])): ?>
                        <li class='nav-item'><a class='nav-link' href='index.php'>Beranda</a></li>
                        <li class='nav-item'><a class='nav-link' href='tambah.php'>Daftar</a></li>
                        <li class='nav-item'><a class='nav-link' href='login.php'>Login admin</a></li>
                    <?php else: ?>
                        <li class='nav-item'><a class='nav-link' href='admin.php'>Pendaftar</a></li>
                        <li class='nav-item'><a class='nav-link' href='kelas.php'>Kelas</a></li>
                        <li class='nav-item'>
                            <form method='post' action='logout.php' class='d-inline'>
                                <input type='hidden' name='csrf' value='<?= e(tokenCsrf()) ?>'>
                                <button class='nav-link btn btn-link' type='submit'>Logout</button>
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class='container py-4'>
        <?php if ($pesan = ambilFlash()): ?>

            <div id='flash' class='d-none' data-pesan='<?= e($pesan) ?>'></div>
        <?php endif; ?>