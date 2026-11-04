<?php 
declare(strict_types=1); 
 
require_once __DIR__ . '/../src/bootstrap.php'; 
require_once __DIR__ . '/../vendor/autoload.php'; 
use Dompdf\Dompdf; 
use Dompdf\Options; 
 
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' 
=> 1]]); 
$isAdmin = !empty($_SESSION['admin_id']);
$isBuktiTerakhir = $id !== false && $id !== null
    && (int) ($_SESSION['bukti_pendaftar_id'] ?? 0) === $id;
if (!$isAdmin && !$isBuktiTerakhir) {
    http_response_code(403);
    exit('Akses bukti pendaftaran tidak diizinkan.');
}

$bukti = ($id === false || $id === null) ? null : ambilBuktiPendaftar(getConnection(), $id);
 
if ($bukti === null) { 
    http_response_code(404); 
    exit('Data tidak ditemukan.'); 
} 
 
$nomor = sprintf('REG-%s-%06d', date('Y', strtotime($bukti['tgl_daftar'])), 
$bukti['id']); 
 
ob_start(); 
require __DIR__ . '/../templates/bukti.php'; 
$html = (string) ob_get_clean(); 
 
$options = new Options(); 
$options->set('isRemoteEnabled', false); 
 
 
$dompdf = new Dompdf($options); 
$dompdf->loadHtml($html); 
$dompdf->setPaper('A5', 'portrait'); 
$dompdf->render(); 
$nomorFile = $nomor . '.pdf';
if (!$isAdmin) {
    unset($_SESSION['bukti_pendaftar_id']);
    session_write_close();
}
$dompdf->stream($nomorFile, ['Attachment' => false]); 