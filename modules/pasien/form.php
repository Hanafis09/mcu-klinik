<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$id = $_GET['id'] ?? '';
$data = [];
if ($id != '') {
  $q = mysqli_query($conn, "SELECT * FROM pasien WHERE id=$id");
  $data = mysqli_fetch_assoc($q);
}

if (isset($_POST['simpan'])) {
  $nama = $_POST['nama'];
  $tgl_lahir = $_POST['tgl_lahir'];
  $jk = $_POST['jenis_kelamin'];
  $perusahaan_id = $_POST['perusahaan_id'];
  $jabatan = $_POST['jabatan'];
  $tgl_mcu = $_POST['tgl_mcu'];

  // foto
  $foto = $data['foto'] ?? '';
  if ($_FILES['foto']['name']) {
    $foto = uniqid() . '_' . $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "../../assets/uploads/$foto");
  }

  if ($id == '') {
    $rm = 'MCU' . date('YmdHis');
    mysqli_query($conn, "INSERT INTO pasien (no_rm, nama, tgl_lahir, jenis_kelamin, perusahaan_id, jabatan, foto, tgl_mcu)
    VALUES ('$rm', '$nama', '$tgl_lahir', '$jk', '$perusahaan_id', '$jabatan', '$foto', '$tgl_mcu')");
  } else {
    mysqli_query($conn, "UPDATE pasien SET 
      nama='$nama', tgl_lahir='$tgl_lahir', jenis_kelamin='$jk',
      perusahaan_id='$perusahaan_id', jabatan='$jabatan', foto='$foto', tgl_mcu='$tgl_mcu' 
      WHERE id=$id");
  }

  header("Location: list.php");
}
?>

<h2><?= $id ? 'Edit' : 'Tambah' ?> Pasien</h2>
<form method="post" enctype="multipart/form-data">
  <label>Nama</label><br>
  <input type="text" name="nama" value="<?= $data['nama'] ?? '' ?>" required><br>

  <label>Tanggal Lahir</label><br>
  <input type="date" name="tgl_lahir" value="<?= $data['tgl_lahir'] ?? '' ?>" required><br>

  <label>Jenis Kelamin</label><br>
  <select name="jenis_kelamin" required>
    <option value="">-- Pilih --</option>
    <option value="L" <?= ($data['jenis_kelamin'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
    <option value="P" <?= ($data['jenis_kelamin'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
  </select><br>

  <label>Perusahaan</label><br>
  <select name="perusahaan_id" required>
    <option value="">-- Pilih --</option>
    <?php
    $q = mysqli_query($conn, "SELECT * FROM perusahaan");
    while ($p = mysqli_fetch_assoc($q)) {
      $sel = ($data['perusahaan_id'] ?? '') == $p['id'] ? 'selected' : '';
      echo "<option value='{$p['id']}' $sel>{$p['nama_perusahaan']}</option>";
    }
    ?>
  </select><br>

  <label>Jabatan</label><br>
  <input type="text" name="jabatan" value="<?= $data['jabatan'] ?? '' ?>" required><br>

  <label>Tanggal MCU</label><br>
  <input type="date" name="tgl_mcu" value="<?= $data['tgl_mcu'] ?? '' ?>" required><br>

  <label>Foto 4x6</label><br>
  <input type="file" name="foto"><br>
  <?php if (!empty($data['foto'])) echo "<img src='../../assets/uploads/{$data['foto']}' width='80'><br>"; ?>

  <button type="submit" name="simpan">Simpan</button>
</form>
<a href="list.php">← Kembali</a>