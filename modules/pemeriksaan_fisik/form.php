<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$pasien_id = $_GET['pasien_id'] ?? '';
if (!$pasien_id) die("ID pasien tidak valid.");

$cek = mysqli_query($conn, "SELECT * FROM pemeriksaan_fisik WHERE pasien_id=$pasien_id");
$data = mysqli_fetch_assoc($cek);

if (isset($_POST['simpan'])) {
  $tinggi = $_POST['tinggi'];
  $berat = $_POST['berat'];
  $td = $_POST['tekanan_darah'];
  $nadi = $_POST['nadi'];
  $suhu = $_POST['suhu'];
  $status_gizi = $_POST['status_gizi'];
  $hasil = $_POST['hasil'];
  $kesimpulan = $_POST['kesimpulan'];

  if ($data) {
    mysqli_query($conn, "UPDATE pemeriksaan_fisik SET 
      tinggi_cm='$tinggi', berat_kg='$berat', tekanan_darah='$td', nadi='$nadi',
      suhu='$suhu', status_gizi='$status_gizi', hasil='$hasil', kesimpulan='$kesimpulan'
      WHERE pasien_id=$pasien_id");
  } else {
    mysqli_query($conn, "INSERT INTO pemeriksaan_fisik 
      (pasien_id, tinggi_cm, berat_kg, tekanan_darah, nadi, suhu, status_gizi, hasil, kesimpulan)
      VALUES 
      ($pasien_id, '$tinggi', '$berat', '$td', '$nadi', '$suhu', '$status_gizi', '$hasil', '$kesimpulan')");
  }

  header("Location: list.php");
}
?>

<h2>Pemeriksaan Fisik</h2>
<form method="post">
  <label>Tinggi Badan (cm)</label><br>
  <input type="number" name="tinggi" value="<?= $data['tinggi_cm'] ?? '' ?>" required><br>

  <label>Berat Badan (kg)</label><br>
  <input type="number" name="berat" value="<?= $data['berat_kg'] ?? '' ?>" required><br>

  <label>Tekanan Darah</label><br>
  <input type="text" name="tekanan_darah" value="<?= $data['tekanan_darah'] ?? '' ?>" required><br>

  <label>Nadi (x/menit)</label><br>
  <input type="number" name="nadi" value="<?= $data['nadi'] ?? '' ?>" required><br>

  <label>Suhu Tubuh (°C)</label><br>
  <input type="text" name="suhu" value="<?= $data['suhu'] ?? '' ?>" required><br>

  <label>Status Gizi</label><br>
  <input type="text" name="status_gizi" value="<?= $data['status_gizi'] ?? '' ?>" required><br>

  <label>Pemeriksaan Umum</label><br>
  <textarea name="hasil" rows="3"><?= $data['hasil'] ?? '' ?></textarea><br>

  <label>Kesimpulan Pemeriksaan</label><br>
  <textarea name="kesimpulan" rows="3"><?= $data['kesimpulan'] ?? '' ?></textarea><br>

  <button type="submit" name="simpan">💾 Simpan</button>
</form>
<a href="list.php">← Kembali</a>