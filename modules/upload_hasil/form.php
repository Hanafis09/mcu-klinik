<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$pasien_id = $_GET['pasien_id'] ?? '';
if (!$pasien_id) die("ID pasien tidak valid.");

$cek = mysqli_query($conn, "SELECT * FROM hasil_penunjang WHERE pasien_id=$pasien_id");
$data = mysqli_fetch_assoc($cek);

if (isset($_POST['simpan'])) {
  $kesimpulan_ekg = $_POST['kesimpulan_ekg'];
  $kesimpulan_treadmill = $_POST['kesimpulan_treadmill'];
  $kesimpulan_radiologi = $_POST['kesimpulan_radiologi'];

  $file_ekg = $data['file_ekg'] ?? '';
  $file_treadmill = $data['file_treadmill'] ?? '';
  $file_radiologi = $data['file_radiologi'] ?? '';

  if ($_FILES['file_ekg']['name']) {
    $file_ekg = 'ekg_' . time() . '_' . $_FILES['file_ekg']['name'];
    move_uploaded_file($_FILES['file_ekg']['tmp_name'], '../../assets/uploads/' . $file_ekg);
  }

  if ($_FILES['file_treadmill']['name']) {
    $file_treadmill = 'treadmill_' . time() . '_' . $_FILES['file_treadmill']['name'];
    move_uploaded_file($_FILES['file_treadmill']['tmp_name'], '../../assets/uploads/' . $file_treadmill);
  }

  if ($_FILES['file_radiologi']['name']) {
    $file_radiologi = 'rad_' . time() . '_' . $_FILES['file_radiologi']['name'];
    move_uploaded_file($_FILES['file_radiologi']['tmp_name'], '../../assets/uploads/' . $file_radiologi);
  }

  if ($data) {
    mysqli_query($conn, "UPDATE hasil_penunjang SET 
      file_ekg='$file_ekg', file_treadmill='$file_treadmill', file_radiologi='$file_radiologi',
      kesimpulan_ekg='$kesimpulan_ekg', kesimpulan_treadmill='$kesimpulan_treadmill', kesimpulan_radiologi='$kesimpulan_radiologi'
      WHERE pasien_id=$pasien_id");
  } else {
    mysqli_query($conn, "INSERT INTO hasil_penunjang 
      (pasien_id, file_ekg, file_treadmill, file_radiologi, kesimpulan_ekg, kesimpulan_treadmill, kesimpulan_radiologi)
      VALUES 
      ($pasien_id, '$file_ekg', '$file_treadmill', '$file_radiologi', '$kesimpulan_ekg', '$kesimpulan_treadmill', '$kesimpulan_radiologi')");
  }

  header("Location: list.php");
}
?>

<h2>Upload File Pemeriksaan EKG / Treadmill / Radiologi</h2>
<form method="post" enctype="multipart/form-data">
  <label>Kesimpulan EKG</label><br>
  <textarea name="kesimpulan_ekg"><?= $data['kesimpulan_ekg'] ?? '' ?></textarea><br>
  <label>Upload File EKG</label><br>
  <input type="file" name="file_ekg"><br>
  <?php if (!empty($data['file_ekg'])) echo "<a href='../../assets/uploads/{$data['file_ekg']}' target='_blank'>Lihat File</a><br>"; ?>

  <label>Kesimpulan Treadmill</label><br>
  <textarea name="kesimpulan_treadmill"><?= $data['kesimpulan_treadmill'] ?? '' ?></textarea><br>
  <label>Upload File Treadmill</label><br>
  <input type="file" name="file_treadmill"><br>
  <?php if (!empty($data['file_treadmill'])) echo "<a href='../../assets/uploads/{$data['file_treadmill']}' target='_blank'>Lihat File</a><br>"; ?>

  <label>Kesimpulan Radiologi</label><br>
  <textarea name="kesimpulan_radiologi"><?= $data['kesimpulan_radiologi'] ?? '' ?></textarea><br>
  <label>Upload File Radiologi</label><br>
  <input type="file" name="file_radiologi"><br>
  <?php if (!empty($data['file_radiologi'])) echo "<a href='../../assets/uploads/{$data['file_radiologi']}' target='_blank'>Lihat File</a><br>"; ?>

  <button type="submit" name="simpan">💾 Simpan</button>
</form>
<a href="list.php">← Kembali</a>