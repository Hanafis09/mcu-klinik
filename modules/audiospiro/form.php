<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$pasien_id = $_GET['pasien_id'] ?? '';
if (!$pasien_id) die("ID pasien tidak valid.");

$cek = mysqli_query($conn, "SELECT * FROM pemeriksaan_audiospiro WHERE pasien_id=$pasien_id");
$data = mysqli_fetch_assoc($cek);

if (isset($_POST['simpan'])) {
  $audiometri_kiri = $_POST['audiometri_kiri'];
  $audiometri_kanan = $_POST['audiometri_kanan'];
  $spirometri_fvc = $_POST['spirometri_fvc'];
  $spirometri_fev1 = $_POST['spirometri_fev1'];
  $spirometri_rasio = $_POST['spirometri_rasio'];
  $kesimpulan = $_POST['kesimpulan'];

  $file_audiometri = $data['file_audiometri'] ?? '';
  $file_spirometri = $data['file_spirometri'] ?? '';

  if ($_FILES['file_audiometri']['name']) {
    $file_audiometri = 'audio_' . time() . '_' . $_FILES['file_audiometri']['name'];
    move_uploaded_file($_FILES['file_audiometri']['tmp_name'], '../../assets/uploads/' . $file_audiometri);
  }

  if ($_FILES['file_spirometri']['name']) {
    $file_spirometri = 'spiro_' . time() . '_' . $_FILES['file_spirometri']['name'];
    move_uploaded_file($_FILES['file_spirometri']['tmp_name'], '../../assets/uploads/' . $file_spirometri);
  }

  if ($data) {
    mysqli_query($conn, "UPDATE pemeriksaan_audiospiro SET 
      audiometri_kiri='$audiometri_kiri', audiometri_kanan='$audiometri_kanan', file_audiometri='$file_audiometri',
      spirometri_fvc='$spirometri_fvc', spirometri_fev1='$spirometri_fev1', spirometri_rasio='$spirometri_rasio',
      file_spirometri='$file_spirometri', kesimpulan='$kesimpulan'
      WHERE pasien_id=$pasien_id");
  } else {
    mysqli_query($conn, "INSERT INTO pemeriksaan_audiospiro 
      (pasien_id, audiometri_kiri, audiometri_kanan, file_audiometri,
       spirometri_fvc, spirometri_fev1, spirometri_rasio, file_spirometri, kesimpulan)
      VALUES 
      ($pasien_id, '$audiometri_kiri', '$audiometri_kanan', '$file_audiometri',
       '$spirometri_fvc', '$spirometri_fev1', '$spirometri_rasio', '$file_spirometri', '$kesimpulan')");
  }

  header("Location: list.php");
}
?>

<h2>Pemeriksaan Audiometri & Spirometri</h2>
<form method="post" enctype="multipart/form-data">
  <h4>Audiometri</h4>
  <label>Kiri</label><br>
  <textarea name="audiometri_kiri"><?= $data['audiometri_kiri'] ?? '' ?></textarea><br>
  <label>Kanan</label><br>
  <textarea name="audiometri_kanan"><?= $data['audiometri_kanan'] ?? '' ?></textarea><br>
  <label>Upload File Audiometri</label><br>
  <input type="file" name="file_audiometri"><br>
  <?php if (!empty($data['file_audiometri'])) echo "<a href='../../assets/uploads/{$data['file_audiometri']}' target='_blank'>Lihat File</a><br>"; ?>

  <h4>Spirometri</h4>
  <label>FVC</label><input type="text" name="spirometri_fvc" value="<?= $data['spirometri_fvc'] ?? '' ?>"><br>
  <label>FEV1</label><input type="text" name="spirometri_fev1" value="<?= $data['spirometri_fev1'] ?? '' ?>"><br>
  <label>Rasio (FEV1/FVC)</label><input type="text" name="spirometri_rasio" value="<?= $data['spirometri_rasio'] ?? '' ?>"><br>
  <label>Upload File Spirometri</label><br>
  <input type="file" name="file_spirometri"><br>
  <?php if (!empty($data['file_spirometri'])) echo "<a href='../../assets/uploads/{$data['file_spirometri']}' target='_blank'>Lihat File</a><br>"; ?>

  <label>Kesimpulan Umum</label><br>
  <textarea name="kesimpulan"><?= $data['kesimpulan'] ?? '' ?></textarea><br>

  <button type="submit" name="simpan">💾 Simpan</button>
</form>
<a href="list.php">← Kembali</a>