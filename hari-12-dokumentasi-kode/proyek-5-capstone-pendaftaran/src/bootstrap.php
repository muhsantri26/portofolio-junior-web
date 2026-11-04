<?php

declare(strict_types=1);

ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
session_set_cookie_params([
    'httponly' => true,
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'samesite' => 'Lax',
]);
session_start();

$konfigurasi = require __DIR__ . '/../config/config.php';
ini_set('display_errors', !empty($konfigurasi['debug']) ? '1' : '0');
error_reporting(E_ALL);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/pendaftar.php';
require_once __DIR__ . '/kelas.php';
require_once __DIR__ . '/auth.php';

/**
 * menangani exception yang tidak tertangani
 * 
 * @param Throwable $e Exception yang tidak tertangani
 * @return void
 */
set_exception_handler(function (Throwable $e): void {
    error_log($e->getMessage());
    http_response_code(500);
    echo 'Terjadi kesalahan pada sistem. Silakan coba lagi.';
});
