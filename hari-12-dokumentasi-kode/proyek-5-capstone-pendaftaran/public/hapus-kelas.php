<?php

declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Metode tidak diizinkan.');
}

cekCsrf();
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false) {
    http_response_code(400);
    exit('ID kelas tidak valid.');
}

try {
    if (hapusKelas(getConnection(), $id)) {
        setFlash('Kelas berhasil dihapus.');
    } else {
        setFlash('Kelas tidak ditemukan.');
    }
} catch (PDOException $e) {
    if ($e->getCode() !== '23000') {
        throw $e;
    }
    setFlash('Kelas tidak dapat dihapus karena masih memiliki pendaftar.');
}

redirect('kelas.php');
