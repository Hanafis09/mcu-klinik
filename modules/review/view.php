<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$pasien_id = $_GET['pasien_id'] ?? '';
if (!$pasien_id) die("ID tidak valid.");

// Ambil data pasien
$pasien = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT p.*, pr.nama_perusahaan 
  FROM pasien p 
  LEFT JOIN perusahaan pr ON p.perusahaan_id = pr.id 
  WHERE p.id = $pasien_id
"));

// Ambil semua hasil pemeriksaan
$dokter = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemeriksaan_dokter WHERE pasien_id=$pasien_id"));
$lab = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemeriksaan_lab WHERE pasien_id=$pasien_id"));
$rad_ekg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemeriksaan_radiologi_ekg WHERE pasien_id=$pasien_id"));
$penunjang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM hasil_penunjang WHERE pasien_id=$pasien_id"));
$audio = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemeriksaan_audiospiro WHERE pasien_id=$pasien_id"));
?>

<h2>REVIEW MCU LENGKAP</h2>

<h3>Identitas Pasien</h3>
<ul>
  <li>Nama: <?= $pasien['nama'] ?></li>
  <li>No Rekam Medis: <?= $pasien['no_rm'] ?></li>
  <li>Perusahaan: <?= $pasien['nama_perusahaan'] ?></li>
  <li>Tanggal Lahir: <?= $pasien['tanggal_lahir'] ?></li>
  <li>Jabatan: <?= $pasien['jabatan'] ?></li>
  <li>Tanggal MCU: <?= $pasien['tgl_mcu'] ?></li>
</ul>

<hr>

<h3>Pemeriksaan Dokter</h3>
<p><?= $dokter['kesimpulan'] ?? 'Belum diisi' ?></p>

<hr>

<h3>Hasil Laboratorium</h3>
<?php if ($lab): ?>
<ul>
  <li>HB: <?= $lab['hb'] ?> g/dL</li>
  <li>Leukosit: <?= $lab['leukosit'] ?></li>
  <li>Kolesterol Total: <?= $lab['kolesterol_total'] ?> mg/dL</li>
  <li>Gula Darah: <?= $lab['gula_darah'] ?> mg/dL</li>
  <li>Kesimpulan: <?= $lab['kesimpulan'] ?></li>
</ul>
<?php else: ?>
<p><em>Belum diisi</em></p>
<?php endif; ?>

<hr>

<h3>Hasil EKG & Radiologi</h3>
<?php if ($rad_ekg): ?>
<p><strong>EKG:</strong> <?= $rad_ekg['hasil_ekg'] ?></p>
<?php if ($rad_ekg['file_ekg']) echo "<a href='../../assets/uploads/{$rad_ekg['file_ekg']}' target='_blank'>Lihat File EKG</a><br>"; ?>

<p><strong>Radiologi:</strong> <?= $rad_ekg['hasil_radiologi'] ?></p>
<?php if ($rad_ekg['file_radiologi']) echo "<a href='../../assets/uploads/{$rad_ekg['file_radiologi']}' target='_blank'>Lihat File Radiologi</a><br>"; ?>
<p><strong>Kesimpulan:</strong> <?= $rad_ekg['kesimpulan'] ?></p>
<?php else: ?>
<p><em>Belum diisi</em></p>
<?php endif; ?>

<hr>

<h3>Hasil Audiometri & Spirometri</h3>
<?php if ($audio): ?>
<ul>
  <li>Audiometri Kiri: <?= $audio['audiometri_kiri'] ?></li>
  <li>Audiometri Kanan: <?= $audio['audiometri_kanan'] ?></li>
  <li>FVC: <?= $audio['spirometri_fvc'] ?> L</li>
  <li>FEV1: <?= $audio['spirometri_fev1'] ?> L</li>
  <li>Rasio: <?= $audio['spirometri_rasio'] ?></li>
  <li>Kesimpulan: <?= $audio['kesimpulan'] ?></li>
</ul>
<?php if ($audio['file_audiometri']) echo "<a href='../../assets/uploads/{$audio['file_audiometri']}' target='_blank'>Lihat Audiometri</a><br>"; ?>
<?php if ($audio['file_spirometri']) echo "<a href='../../assets/uploads/{$audio['file_spirometri']}' target='_blank'>Lihat Spirometri</a><br>"; ?>
<?php else: ?>
<p><em>Belum diisi</em></p>
<?php endif; ?>

<hr>
<a href="../../index.php">← Kembali ke Dashboard</a>
<a href="../cetak/pdf.php?pasien_id=<?= $pasien_id ?>" target="_blank">🖨️ Cetak PDF</a>