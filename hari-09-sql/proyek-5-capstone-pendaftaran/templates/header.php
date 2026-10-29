<?php /* templates/header.php */ ?>
<!DOCTYPE html>
<html lang='id'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title><?= e($judul ?? 'Pendaftaran Pelatihan') ?></title>
</head>

<body>
    <header>
        <h1>Pendaftaran Pelatihan</h1>
        <nav>
            <?php
            if (empty($_SESSION['admin_login'])) {
                echo "<a href='index.php'>user</a> | ";
                echo "<a href='tambah.php'>Tambah</a> | ";
                echo "<a href='login.php'>login</a> |";
            } else {
                echo "<a href='admin.php'>Daftar</a> | ";
                echo "<a href='logout.php'>logout</a>";
            }
            ?>
        </nav>
    </header>
    <main>
        <?php if ($pesan = ambilFlash()): ?><p role='status'><?= e($pesan) ?></p><?php
                                                                                endif; ?>