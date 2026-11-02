<?php 
declare(strict_types=1); 
 
function cariAdmin(PDO $pdo, string $username): ?array 
{ 
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admin WHERE 
username = :u'); 
    $stmt->execute(['u' => $username]); 
    $baris = $stmt->fetch(); 
    return $baris === false ? null : $baris; 
} 
 
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
 
function wajibLogin(): void 
{ 
 
    if (empty($_SESSION['admin_id'])) { 
        redirect('login.php'); 
    } 
} 
 
function logout(): void 
{ 
    $_SESSION = []; 
    if (ini_get('session.use_cookies')) { 
        $p = session_get_cookie_params(); 
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], 
$p['secure'], $p['httponly']); 
    } 
    session_destroy(); 
} 