<?php 
declare(strict_types=1); 
 
function getConnection(): PDO 
{ 
    static $pdo = null; 
 
    if ($pdo === null) { 
        $fileKonfigurasi = __DIR__ . '/config.php';
        if (!is_file($fileKonfigurasi)) {
            throw new RuntimeException(
                'Berkas config/config.php belum tersedia. Salin config/config.contoh.php dan sesuaikan pengaturannya.'
            );
        }

        $c = require $fileKonfigurasi;
        foreach (['host', 'nama_db', 'user', 'sandi'] as $kunci) {
            if (!array_key_exists($kunci, $c)) {
                throw new RuntimeException('Pengaturan database tidak lengkap: ' . $kunci);
            }
        }

        $dsn = "mysql:host={$c['host']};dbname={$c['nama_db']};charset=utf8mb4"; 
        $pdo = new PDO($dsn, $c['user'], $c['sandi'], [ 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
            PDO::ATTR_EMULATE_PREPARES => false, 
        ]); 
    } 
 
    return $pdo; 
} 