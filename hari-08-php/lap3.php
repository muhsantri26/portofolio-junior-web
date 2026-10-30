<?php
declare(strict_types=1);

function hitungBmi(float $berat, float $tinggiCm): float
{
    $tinggiM = $tinggiCm / 100;
    return $berat / ($tinggiM * $tinggiM);
}

function kategoriBmi(float $bmi): string
{
    return match (true) {
        $bmi < 18.5 => 'Kurang',
        $bmi < 25 => 'Normal',
        $bmi < 30 => 'Lebih',
        default => 'Obesitas',
    };
}

$galat = [];
$hasil = null;
$berat = trim((string) ($_POST['berat'] ?? ''));
$tinggi = trim((string) ($_POST['tinggi'] ?? ''));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (filter_var($berat, FILTER_VALIDATE_FLOAT) === false || (float) $berat <= 0) {
        $galat['berat'] = 'Berat harus angka lebih dari 0.';
    }
    if (filter_var($tinggi, FILTER_VALIDATE_FLOAT) === false || (float) $tinggi <= 0) {
        $galat['tinggi'] = 'Tinggi harus angka lebih dari 0.';
    }
    if ($galat === []) {
        $bmi = hitungBmi((float) $berat, (float) $tinggi);
        $hasil = number_format($bmi, 1) . ' (' . kategoriBmi($bmi) . ')';
    }
}
?>
<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <title>Kalkulator BMI</title>
</head>
<body>
    <h1>Kalkulator BMI</h1>
    <form method='post'>
        <p>
            <label for='berat'>Berat (kg)</label>
            <input id='berat' name='berat' value='<?= htmlspecialchars(
                                                        $berat,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>'>
            <?= isset($galat['berat']) ? '<span>' . htmlspecialchars($galat['berat']) .
                '</span>' : '' ?>
        </p>
        <p>
            <label for='tinggi'>Tinggi (cm)</label>
            <input id='tinggi' name='tinggi' value='<?= htmlspecialchars(
                                                        $tinggi,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>'>
            <?= isset($galat['tinggi']) ? '<span>' . htmlspecialchars($galat['tinggi']) .
                '</span>' : '' ?>
        </p>
        <button type='submit'>Hitung</button>
    </form>
    <?php if ($hasil !== null): ?>
        <p>Hasil BMI: <strong><?= htmlspecialchars($hasil) ?></strong></p>
    <?php endif; ?>
</body>
</html>