<?php 
declare(strict_types=1); 
 
if (PHP_SAPI !== 'cli') { 
    exit('Hanya dapat dijalankan dari terminal.'); 
} 
 
require_once __DIR__ . '/../config/database.php'; 
 
$username = $argv[1] ?? ''; 
$sandi = $argv[2] ?? ''; 
 
if (strlen($username) < 3 || strlen($sandi) < 8) { 
    exit('Gunakan: php buat-admin.php <username> <sandi minimal 8 karakter>' . 
PHP_EOL); 
} 
 
$stmt = getConnection()->prepare('INSERT INTO admin (username, password_hash) VALUES 
(:u, :p)'); 
$stmt->execute(['u' => $username, 'p' => password_hash($sandi, PASSWORD_DEFAULT)]); 
echo 'Admin dibuat.' . PHP_EOL;