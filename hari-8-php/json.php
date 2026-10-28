<?php
$fileJson = 'data/peserta.json';

// Pastikan folder 'data' ada agar tidak terjadi error
if (!is_dir('data')) {
    mkdir('data', 0777, true);
}

// 1. Data awal
$peserta = [
    ['nama' => 'Sari', 'kelas' => 'Web', 'nilai' => 90],
    ['nama' => 'Budi', 'kelas' => 'Web', 'nilai' => 68],
    ['nama' => 'Citra', 'kelas' => 'Data', 'nilai' => 90],
];

// 2. Simpan array ke JSON (json_encode)
// JSON_PRETTY_PRINT digunakan agar format JSON di dalam file rapi dan mudah dibaca
$jsonAwal = json_encode($peserta, JSON_PRETTY_PRINT);
file_put_contents($fileJson, $jsonAwal);
echo "1. Data awal berhasil disimpan ke <strong>$fileJson</strong>.<br>";


// 3. Baca kembali file JSON yang baru disimpan
$jsonDibaca = file_get_contents($fileJson);

// 4. Ubah JSON kembali menjadi array PHP (json_decode)
// Parameter 'true' WAJIB ditambahkan agar hasilnya menjadi associative array, bukan object
$pesertaDariJson = json_decode($jsonDibaca, true);


// 5. Tambahkan satu peserta baru ke dalam array
$pesertaDariJson[] = ['nama' => 'Joko', 'kelas' => 'UI/UX', 'nilai' => 85];


// 6. Simpan ulang data yang sudah ditambah ke dalam file JSON
$jsonBaru = json_encode($pesertaDariJson, JSON_PRETTY_PRINT);
file_put_contents($fileJson, $jsonBaru);
echo "2. Peserta baru (Joko) berhasil ditambahkan dan file disimpan ulang.<br><hr>";


// Menampilkan hasil akhir isi file JSON
echo "<h3>Isi $fileJson saat ini:</h3>";
echo "<pre>" . htmlspecialchars(file_get_contents($fileJson)) . "</pre>";

//mengubah json menjadi array
$fileJson = 'data/peserta.json';
$dataPeserta = [];

// 1. Cek apakah file JSON ada
if (file_exists($fileJson)) {
    // 2. Baca isi file JSON
    $isiJson = file_get_contents($fileJson);
    
    // 3. Ubah JSON menjadi array (jangan lupa parameter 'true')
    $dataPeserta = json_decode($isiJson, true);
}
echo "<p>" . print_r($dataPeserta). "</p>";
foreach ($dataPeserta as $p) {
    echo "Nama: " . $p['nama'] .  " | Nilai: " . $p['kelas'] . "<br>";
}

?>