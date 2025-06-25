<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$setting = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM setting_klinik WHERE id=1"));
?>

<h2>Pengaturan Klinik</h2>
<form method="post" action="update.php" enctype="multipart/form-data">
  <label>Nama Klinik:</label><br>
  <input type="text" name="nama_klinik" value="<?= $setting['nama_klinik'] ?>"><br><br>

  <label>Alamat Klinik:</label><br>
  <textarea name="alamat"><?= $setting['alamat'] ?></textarea><br><br>

  <label>Logo Klinik:</label><br>
  <input type="file" name="logo"><br>
  <?php if ($setting['logo']) echo "<img src='../../assets/uploads/{$setting['logo']}' height='50'>"; ?><br><br>

  <label>Wallpaper (Login / Dashboard):</label><br>
  <input type="file" name="wallpaper"><br>
  <?php if ($setting['wallpaper']) echo "<img src='../../assets/uploads/{$setting['wallpaper']}' height='50'>"; ?><br><br>

  <button type="submit" name="simpan">💾 Simpan</button>
</form>

<a href="../../index.php">← Kembali ke Dashboard</a>