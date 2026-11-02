<?php 
declare(strict_types=1); 
 
require_once __DIR__ . '/../src/validasi.php'; 
 
$hasilUji = []; 
 
function uji(array &$hasil, string $nama, mixed $diharapkan, mixed $aktual): void 
{ 
    $hasil[] = [$nama, $diharapkan === $aktual, $diharapkan, $aktual]; 
} 
 
uji($hasilUji, 'HP 10 digit lolos', true, validNoHp('0812345678')); 
uji($hasilUji, 'HP 9 digit gagal', false, validNoHp('081234567')); 
uji($hasilUji, 'HP 14 digit gagal', false, validNoHp('08123456789012')); 
uji($hasilUji, 'HP huruf gagal', false, validNoHp('08abc45678')); 
uji($hasilUji, 'Sisa kuota normal', 5, hitungSisaKuota(30, 25)); 
uji($hasilUji, 'Sisa kuota tidak negatif', 0, hitungSisaKuota(30, 31)); 
uji($hasilUji, 'Nomor bukti', 'REG-2026-000007', formatNomorBukti(2026, 7));

// uji 5 kasus uji
uji($hasilUji, 'Hp 13 digit lolos', true, validNoHp('0812345678901'));
uji($hasilUji, 'Hp karakter gagal', false, validNoHp('081-354-789'));
uji($hasilUji, 'sisa kuota nol', 0, hitungSisaKuota(30, 30));
uji($hasilUji, 'Nomor bukti', 'REG-2026-111111', formatNomorBukti(2026, 111111));
uji($hasilUji, 'Nomor bukit', 'REG-2026-1111111', formatNomorBukti(2026, 1111111));
uji($hasilUji, 'Nomor bukti', 'REG-2026-000222', formatNomorBukti(2026, 222));

$gagal = 0; 
foreach ($hasilUji as [$nama, $lolos, $diharapkan, $aktual]) { 
    if ($lolos) { 
        echo '[LOLOS] ' . $nama . PHP_EOL. '<br>'; 
    } else { 
        $gagal++; 
        echo '[GAGAL] ' . $nama . ' | diharapkan ' . var_export($diharapkan, true) 
            . ', aktual ' . var_export($aktual, true) . PHP_EOL. '<br>'; 
    } 
} 
echo PHP_EOL . ($gagal === 0 ? 'Semua uji lolos.' : $gagal . ' uji gagal.') . 
PHP_EOL; 
exit($gagal === 0 ? 0 : 1);