<?php
// Koneksi ke database sesuai schema latihan SQL
$host = 'localhost';
$db   = 'db_pelatihan';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$table = 'pendaftar';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

try {
    $cekTabel = $pdo->query("SHOW TABLES LIKE '$table'");
    if (!$cekTabel->fetch()) {
        throw new Exception("Tabel '$db.$table' tidak ditemukan. Import database latihan terlebih dahulu.");
    }
} catch (Exception $e) {
    die($e->getMessage());
}

echo "<h2>DEMO SQL INJECTION</h2>";
echo "<form method='get'>Email: <input name='email' value='" . htmlspecialchars($_GET['email'] ?? '') . "'> <button>Cari</button></form>";

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    echo "<h3>Versi Berbahaya (RAW SQL)</h3>";
    // BERBAHAYA: input x' OR '1'='1 membuat kondisi selalu benar
    $sql = "SELECT * FROM $table WHERE email = '" . $email . "'";
    echo "<code>" . htmlspecialchars($sql) . "</code><br>";
    $hasil = $pdo->query($sql);
    $baris = $hasil->fetch();
    if ($baris) {
        echo "<b>Data ditemukan!</b><br>";
        echo htmlspecialchars(json_encode($baris));
    } else {
        echo "<b>Tidak ditemukan.</b>";
    }

    // echo "<hr><h3>Versi Aman (Prepared Statement)</h3>";
    // // AMAN: prepared statement; data dikirim terpisah dari perintah SQL
    // $stmt = $pdo->prepare("SELECT * FROM $table WHERE email = :email");
    // $stmt->execute(['email' => $email]);
    // $baris2 = $stmt->fetch();
    // echo "<code>SELECT * FROM $table WHERE email = :email</code><br>";
    // if ($baris2) {
    //     echo "<b>Data ditemukan!</b><br>";
    //     echo htmlspecialchars(json_encode($baris2));
    // } else {
    //     echo "<b>Tidak ditemukan.</b>";
    // }

    // echo "<hr><b>Penjelasan:</b> Versi berbahaya rentan terhadap SQL Injection, sehingga input seperti <code>x' OR '1'='1</code> akan membuat query selalu benar dan menampilkan data. Versi aman menggunakan prepared statement, sehingga input apapun tidak akan mengubah struktur query dan tetap aman dari injeksi.";
}
?>
