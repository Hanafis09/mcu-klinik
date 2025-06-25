<?php
include '../../config/db.php';

if ($_FILES['sql_file']['name']) {
  $tmp = $_FILES['sql_file']['tmp_name'];
  $path = "uploads/" . $_FILES['sql_file']['name'];
  move_uploaded_file($tmp, $path);

  // Import SQL
  exec("mysql -u root mcu_klinik < $path"); // Sesuaikan user dan DB

  echo "✅ Restore database berhasil.";
  echo "<br><a href='index.php'>← Kembali</a>";
} else {
  echo "❌ File SQL tidak ditemukan.";
}