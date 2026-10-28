<?php

declare(strict_types=1);

$peserta = [
    ['nama' => 'Sari', 'kelas' => 'Web', 'nilai' => 90],
    ['nama' => 'Budi', 'kelas' => 'Web', 'nilai' => 68],
    ['nama' => 'Citra', 'kelas' => 'Data', 'nilai' => 82],
];

// hitungRataRata(array $daftar): float dan cariTertinggi(array $daftar): ?array. 
function hitungRataRata(array $daftar): float
{
    $total = array_sum(array_column($daftar, 'nilai'));
    return $total / count($daftar);
}

function cariTertinggi(array $daftar): ?array
{
    $maxNilai = max(array_column($daftar, 'nilai'));
    $result = array_filter($daftar, function ($item) use ($maxNilai) {
        return $item['nilai'] === $maxNilai;
    });
    return array_values($result)[0] ?? null;
}

echo '<h3>hasil fungsi</h3>';
$rataRata = hitungRataRata($peserta);
echo '<p>Rata Rata Nilai: ' . $rataRata . '</p>';
$tertinggi = cariTertinggi($peserta);
if ($tertinggi) {
    echo '<p>Pesertta dengan nilai tertinggi: ' . $tertinggi['nama'] . ' Adalah ' . $tertinggi['nilai'] . '</p>';
} else {
    echo '<p>Tidak Ada Peserta</p>';
}

// filterLulus(array $peserta, int $batas = 70): array dengan array_filter. 
function filterNilai(array $daftar): array
{
    $result = array_filter($daftar, function ($item) {
        return $item['nilai'] > 70;
    });
    // array_values digunakan untuk mereset index array menjadi barurutan dari 0
    return array_values($result);
}

$hasilFilter = filterNilai($peserta);
// print_r($hasilFileter);
foreach ($hasilFilter as $siswa) {
    echo "Nama: " . $siswa['nama'] . " - Nilai: " . $siswa['nilai'] . "<br>";
}

// urutkanNilai(array $peserta): array dengan usort (kembalikan salinan).
echo "<h3>Urutkan Nilai </h3>";
function urutkanNilai(array $peserta): array
{
    // membuat salinan array
    $salinanPeserta = $peserta;
    // mengurtukan salinan mengunakan usort
    usort($salinanPeserta, function ($a, $b) {
        // mengurutkan dari nilai terbesar ke terkecil(descending)
        // jika ingin dari terkecil ke terbesar gunakan: return $a['nilai'] <=> $b['nilai'];
        return $b['nilai'] <=> $a['nilai'];
    });
    return $salinanPeserta;
}
$pesertaTelahDiurutkan = urutkanNilai($peserta);

// mencetak hasil
foreach ($pesertaTelahDiurutkan as $p) {
    echo "Nama: " . $p['nama'] . " | Nilai: " . $p['nilai'] . "<br>";
}

// kelompokkanPerKelas(array $peserta): array yang menghasilkan ['Web' => [...], 'Data' => [...]].
function kelompokkanPerKelas(array $peserta): array{
    $hasil = [];
    foreach($peserta as $p){
        $kelas = $p['kelas'];
        // memasukan data peserta kedalam array
        $hasil[$kelas][] = $p;
    }
    return $hasil;
}

$dataPerKelas = kelompokkanPerKelas($peserta);
foreach ($dataPerKelas as $namaKelas => $daftarPeserta){
    // cetak anam kelas sebagai juduul 
    echo "<h3>Kelas " . $namaKelas . "</h3>";
    // buat list html
    echo "<ul>";
    // perulangan dalam: mengambil setiap peserta di dalam kelas tsb
    foreach ($daftarPeserta as $siswa){
        echo "<li>Nama;" . $siswa['nama'] . " | Nilai: " . $siswa['nilai'] . "</li>";
    }
    // tutup list html
    echo "</ul>";
    echo "<hr>";
}
// Tampilkan hasil dalam tabel HTML berisi nomor, nama, kelas, nilai, dan grade. Semua output di-escape dengan htmlspecialchars. 
echo '<h3>Daftar Nilai Peserta</h3>';
echo '<table border="1" cellpadding="8" cellspacing="0">';
echo '<thead><tr><th>Nomor</th><th>Nama</th><th>Kelas</th><th>Nilai</th><th>Grade</th></tr></thead>';
echo '<tbody>';

foreach ($peserta as $index => $siswa) {
    $grade = match (true) {
        $siswa['nilai'] >= 80 => 'A',
        $siswa['nilai'] >= 70 => 'B',
        $siswa['nilai'] >= 60 => 'C',
        default => 'D',
    };

    echo '<tr>';
    echo '<td>' . htmlspecialchars((string) ($index + 1), ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($siswa['nama'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($siswa['kelas'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars((string) $siswa['nilai'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($grade, ENT_QUOTES, 'UTF-8') . '</td>';
    echo '</tr>';
}

echo '</tbody></table>';