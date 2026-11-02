<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/validasi.php';

$hasilUji = [];

function uji(array &$hasil, string $nama, mixed $diharapkan, mixed $aktual): void
{
    $hasil[] = [$nama, $diharapkan === $aktual, $diharapkan, $aktual];
}

uji($hasilUji, 'HP 10 digit valid', true, validNoHp('0812345678'));
uji($hasilUji, 'HP 13 digit valid', true, validNoHp('0812345678901'));
uji($hasilUji, 'HP 9 digit tidak valid', false, validNoHp('081234567'));
uji($hasilUji, 'HP 14 digit tidak valid', false, validNoHp('08123456789012'));
uji($hasilUji, 'HP kosong tidak valid', false, validNoHp(''));
uji($hasilUji, 'HP berisi huruf tidak valid', false, validNoHp('08abc45678'));
uji($hasilUji, 'HP berisi spasi tidak valid', false, validNoHp('081234 5678'));
uji($hasilUji, 'HP dengan newline tidak valid', false, validNoHp("0812345678\n"));
uji($hasilUji, 'HP berisi karakter khusus tidak valid', false, validNoHp('<script>'));

uji($hasilUji, 'Sisa kuota normal', 5, hitungSisaKuota(30, 25));
uji($hasilUji, 'Kuota kosong', 0, hitungSisaKuota(0, 0));
uji($hasilUji, 'Kuota tepat penuh', 0, hitungSisaKuota(30, 30));
uji($hasilUji, 'Pendaftar melebihi kuota tidak menghasilkan nilai negatif', 0, hitungSisaKuota(30, 31));
uji($hasilUji, 'Kuota negatif tidak menghasilkan nilai negatif', 0, hitungSisaKuota(-1, 0));

uji($hasilUji, 'Nomor bukti dengan ID satu digit', 'REG-2026-000007', formatNomorBukti(2026, 7));
uji($hasilUji, 'Nomor bukti dengan ID tiga digit', 'REG-2026-000222', formatNomorBukti(2026, 222));
uji($hasilUji, 'Nomor bukti dengan ID enam digit', 'REG-2026-111111', formatNomorBukti(2026, 111111));
uji($hasilUji, 'Nomor bukti mempertahankan ID lebih dari enam digit', 'REG-2026-1111111', formatNomorBukti(2026, 1111111));

$gagal = 0;
foreach ($hasilUji as [$nama, $lolos, $diharapkan, $aktual]) {
    if ($lolos) {
        echo '[LOLOS] ' . $nama . PHP_EOL .'<br>';
        continue;
    }

    $gagal++;
    echo '[GAGAL] ' . $nama
        . ' | diharapkan ' . var_export($diharapkan, true)
        . ', aktual ' . var_export($aktual, true)
        . PHP_EOL . '<br>';
}

echo PHP_EOL . ($gagal === 0 ? 'Semua uji lolos.' : $gagal . ' uji gagal.') . PHP_EOL;
exit($gagal === 0 ? 0 : 1);
