<?php 
declare(strict_types=1); 

/**
 * mengambilsatu admin berdasarkan username
 * @param PDO $pdo koneksi database aktif
 * @param string $username Username admin
 * @return array<string, mixed>|null baris admin , atau null bila tidak ditemukan 
 */
 
function cariAdmin(PDO $pdo, string $username): ?array 
{ 
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admin WHERE 
username = :u'); 
    $stmt->execute(['u' => $username]); 
    $baris = $stmt->fetch(); 
    return $baris === false ? null : $baris; 
} 
 
/**
 * memporses login admin
 * @param PDO $pdo koneksi database aktif
 * @param string $username Username admin
 * @param string $sandi Password admin
 * @return bool true bila login berhasil, false sebaliknya
 */
function prosesLogin(PDO $pdo, string $username, string $sandi): bool 
{ 
    $admin = cariAdmin($pdo, $username); 
    if ($admin === null || !password_verify($sandi, $admin['password_hash'])) { 
        return false; 
    } 
    session_regenerate_id(true); 
    $_SESSION['admin_id'] = (int) $admin['id']; 
    return true; 
} 
 
/**
 * Memastikan pengguna telah login.
 */
function wajibLogin(): void 
{ 
    cekLoginAdmin();
} 
 
/**
 * Memproses logout admin.
 */
function logout(): void 
{ 
    $_SESSION = []; 
    if (ini_get('session.use_cookies')) { 
        $p = session_get_cookie_params(); 
setcookie(session_name(), '', [
    'expires' => time() - 42000,
    'path' => $p['path'],
    'domain' => $p['domain'],
    'secure' => $p['secure'],
    'httponly' => $p['httponly'],
    'samesite' => $p['samesite'] ?? 'Lax',
]);
    } 
    session_destroy(); 
} 