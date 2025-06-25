<?php
require_once '../../vendor/autoload.php';
include '../../config/db.php';

$pasien_id = $_GET['pasien_id'] ?? '';
if (!$pasien_id) die("ID pasien tidak valid.");

$pasien = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT p.*, pr.nama_perusahaan 
  FROM pasien p 
  LEFT JOIN perusahaan pr ON p.perusahaan_id = pr.id 
  WHERE p.id = $pasien_id
"));

$dokter = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemeriksaan_dokter WHERE pasien_id=$pasien_id"));
$lab = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemeriksaan_lab WHERE pasien_id=$pasien_id"));
$rad_ekg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemeriksaan_radiologi_ekg WHERE pasien_id=$pasien_id"));
$penunjang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM hasil_penunjang WHERE pasien_id=$pasien_id"));
$audio = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemeriksaan_audiospiro WHERE pasien_id=$pasien_id"));

$html = '
<h2 style="text-align:center;">HASIL MEDICAL CHECK UP</h2>
<h3>IDENTITAS PASIEN</h3>
<table>
<tr><td>Nama</td><td>: '.$pasien['nama'].'</td></tr>
<tr><td>No RM</td><td>: '.$pasien['no_rm'].'</td></tr>
<tr><td>Tgl Lahir</td><td>: '.$pasien['tanggal_lahir'].'</td></tr>
<tr><td>Perusahaan</td><td>: '.$pasien['nama_perusahaan'].'</td></tr>
<tr><td>Jabatan</td><td>: '.$pasien['jabatan'].'</td></tr>
<tr><td>Tanggal MCU</td><td>: '.$pasien['tgl_mcu'].'</td></tr>
</table>
<hr>
<h3>PEMERIKSAAN FISIK</h3>
<p>'.($dokter['kesimpulan'] ?? 'Belum Diisi').'</p>

<h3>LABORATORIUM</h3>
<ul>
  <li>HB: '.$lab['hb'].' | Leukosit: '.$lab['leukosit'].' | Kolesterol Total: '.$lab['kolesterol_total'].'</li>
  <li>Gula Darah: '.$lab['gula_darah'].' | HDL: '.$lab['hdl'].' | LDL: '.$lab['ldl'].'</li>
  <li>Kesimpulan: '.$lab['kesimpulan'].'</li>
</ul>

<h3>RADIOLOGI & EKG</h3>
<p><b>EKG:</b> '.$rad_ekg['hasil_ekg'].'<br>
<b>Radiologi:</b> '.$rad_ekg['hasil_radiologi'].'<br>
<b>Kesimpulan:</b> '.$rad_ekg['kesimpulan'].'</p>

<h3>AUDIOMETRI & SPIROMETRI</h3>
<ul>
  <li>Audiometri Kiri: '.$audio['audiometri_kiri'].' | Kanan: '.$audio['audiometri_kanan'].'</li>
  <li>FVC: '.$audio['spirometri_fvc'].' | FEV1: '.$audio['spirometri_fev1'].' | Rasio: '.$audio['spirometri_rasio'].'</li>
  <li>Kesimpulan: '.$audio['kesimpulan'].'</li>
</ul>

<hr>
<p><b>Dokter Pemeriksa:</b></p>
<table width="100%">
<tr>
<td></td>
<td align="center">
<img src="barcode.php?text='.urlencode('Dr. Hanafi SIP-123456').'" alt="ttd" width="150"><br>
<b>dr. Hanafi</b><br>
SIP: 123456
</td>
</tr>
</table>
';

// Konversi HTML ke PDF
$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
$mpdf->WriteHTML($html);
$mpdf->Output("Hasil_MCU_".$pasien['no_rm'].".pdf", "I"); // "I" = open in browser