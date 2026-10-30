<?php
$fileCsv = 'data/peserta.csv';

// Pastikan folder 'data' ada
if (!is_dir('data')) {
    mkdir('data', 0777, true);
}

// 1. Data array awal
$peserta = [
    ['nama' => 'Sari', 'kelas' => 'Web', 'nilai' => 90],
    ['nama' => 'Budi', 'kelas' => 'Web', 'nilai' => 68],
    ['nama' => 'Citra', 'kelas' => 'Data', 'nilai' => 90],
    ['nama' => 'Joko', 'kelas' => 'UI/UX', 'nilai' => 85]
];

// ==========================================
// 2. EKSPOR KE CSV (fputcsv)
// ==========================================
// Buka file dengan mode 'w' (write/tulis)
$fileTulis = fopen($fileCsv, 'w');

// Tulis baris pertama sebagai Header kolom
fputcsv($fileTulis, ['Nama', 'Kelas', 'Nilai']);

// Looping untuk menulis setiap baris data peserta ke CSV
foreach ($peserta as $p) {
    fputcsv($fileTulis, [$p['nama'], $p['kelas'], $p['nilai']]);
}

// Tutup file setelah selesai menulis
fclose($fileTulis);


// ==========================================
// 3. IMPOR DARI CSV (fgetcsv)
// ==========================================
$dataDariCsv = [];
$headerCsv = [];

// Buka file dengan mode 'r' (read/baca)
if (($fileBaca = fopen($fileCsv, 'r')) !== false) {
    
    // Ambil baris pertama sebagai header tabel (Nama, Kelas, Nilai)
    $headerCsv = fgetcsv($fileBaca);
    
    // Ambil baris-baris selanjutnya sebagai isi data selama belum mencapai akhir file
    while (($baris = fgetcsv($fileBaca)) !== false) {
        $dataDariCsv[] = $baris;
    }
    
    // Tutup file setelah selesai membaca
    fclose($fileBaca);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Impor & Ekspor CSV</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Data Peserta dari File CSV</h2>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <!-- Menampilkan Header dari file CSV -->
                <?php foreach ($headerCsv as $judulKolom): ?>
                    <th><?php echo htmlspecialchars($judulKolom); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            // Menampilkan Data dari file CSV
            foreach ($dataDariCsv as $barisData): 
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($barisData[0]); ?></td>
                    <td><?php echo htmlspecialchars($barisData[1]); ?></td>
                    <td><?php echo htmlspecialchars($barisData[2]); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>