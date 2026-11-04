<?php

declare(strict_types=1);

/**
 * mengamankan text untuk ditampilkan di html
 * 
 * @param string|null $teks Teks yang akan diamankan
 * @return string Teks yang sudah diamankan
 */
function e(?string $teks): string
{
    return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * melakukan redirecct ke url tertentu
 * 
 * @param string $url URL tujuan
 * @return never
 */

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

/**
 * Menghasilkan token CSRF.
 *
 * @return string Token CSRF.
 */
function tokenCsrf(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
function cekCsrf(): void
{
    $kiriman = (string) ($_POST['csrf'] ?? '');
    $tersimpan = (string) ($_SESSION['csrf'] ?? '');
    if ($tersimpan === '' || !hash_equals($tersimpan, $kiriman)) {
        http_response_code(403);
        exit('Permintaan tidak valid.');
    }
}

function isDuplicateKeyError(PDOException $exception): bool
{
    return ($exception->errorInfo[1] ?? null) === 1062;
}
function setFlash(string $pesan): void
{
    $_SESSION['flash'] = $pesan;
}
function ambilFlash(): ?string
{
    $pesan = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $pesan;
}

function cekLoginAdmin(): void
{
    if (empty($_SESSION['admin_id'])) {
        setFlash('Silahkan login dulu');
        redirect('login.php');
    }
}