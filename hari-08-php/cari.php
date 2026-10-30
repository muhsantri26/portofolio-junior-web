<?php
$peserta = [
    ['nama' => 'Sari', 'kelas' => 'Web', 'nilai' => 90],
    ['nama' => 'Budi', 'kelas' => 'Web', 'nilai' => 68],
    ['nama' => 'Citra', 'kelas' => 'Data', 'nilai' => 90],
];

// Mengambil query string 'q' dari URL, jika tidak ada maka default ke string kosong
$kataKunci = isset($_GET['q']) ? trim($_GET['q']) : '';
$hasilPencarian = [];

// Proses penyaringan (filtering)
if ($kataKunci !== '') {
    $hasilPencarian = array_filter($peserta, function ($p) use ($kataKunci) {
        // stripos mengembalikan false jika string tidak ditemukan
        return stripos($p['nama'], $kataKunci) !== false;
    });
} else {
    // Jika tidak ada pencarian, tampilkan semua peserta
    $hasilPencarian = null; //$peserta; 
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pencarian Peserta</title>
</head>

<body>
    <h2>Cari Peserta</h2>

    <!-- Form pencarian dengan metode GET -->
    <form action="cari.php" method="GET">
        <input type="text" name="q" value="<?php echo htmlspecialchars($kataKunci); ?>" placeholder="Cari nama peserta...">
        <button type="submit">Cari</button>
    </form>

    <hr>

    <h3>Hasil Pencarian:</h3>
    <?php if (!empty($kataKunci)): ?>
        <p>Menampilkan hasil untuk: <strong><?php echo htmlspecialchars($kataKunci); ?></strong></p>
    <?php endif; ?>

    <?php
    // Menampilkan pesan bila data kosong / tidak ditemukan
    if (empty($hasilPencarian)) {
        echo "<p><em>Maaf, peserta dengan nama tersebut tidak ditemukan.</em></p>";
    } else {
        echo "<ul>";
        foreach ($hasilPencarian as $siswa) {
            echo "<li>Nama: <strong>" . htmlspecialchars($siswa['nama']) . "</strong> | Kelas: " . htmlspecialchars($siswa['kelas']) . " | Nilai: " . $siswa['nilai'] . "</li>";
        }
        echo "</ul>";
    }
    ?>
</body>

</html>