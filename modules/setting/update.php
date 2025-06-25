<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$nama = $_POST['nama_klinik'];
$alamat = $_POST['alamat'];

$logo = '';
$wall = '';

if ($_FILES['logo']['name']) {
  $logo = 'logo_' . time() . '_' . $_FILES['logo']['name'];
  move_uploaded_file($_FILES['logo']['tmp_name'], '../../assets/uploads/' . $logo);
  mysqli_query($conn, "UPDATE setting_klinik SET logo='$logo' WHERE id=1");
}

if ($_FILES['wallpaper']['name']) {
  $wall = 'wall_' . time() . '_' . $_FILES['wallpaper']['name'];
  move_uploaded_file($_FILES['wallpaper']['tmp_name'], '../../assets/uploads/' . $wall);
  mysqli_query($conn, "UPDATE setting_klinik SET wallpaper='$wall' WHERE id=1");
}

mysqli_query($conn, "UPDATE setting_klinik SET 
  nama_klinik='$nama', alamat='$alamat' 
  WHERE id=1");

header("Location: form.php");