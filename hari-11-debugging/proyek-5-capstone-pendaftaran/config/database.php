<?php 
declare(strict_types=1); 
 
function getConnection(): PDO 
{ 
    static $pdo = null; 
 
    if ($pdo === null) { 
        $c = require __DIR__ . '/config.php'; 
        $dsn = "mysql:host={$c['host']};dbname={$c['nama_db']};charset=utf8mb4"; 
        $pdo = new PDO($dsn, $c['user'], $c['sandi'], [ 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
            PDO::ATTR_EMULATE_PREPARES => false, 
        ]); 
    } 
 
    return $pdo; 
} 