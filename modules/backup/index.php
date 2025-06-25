<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");
?>

<h2>Backup & Restore Database</h2>

<!-- Tombol Backup -->
<form method="post" action="backup.php">
  <button type="submit">⬇️ Backup Sekarang</button>
</form>

<br>

<!-- Form Restore -->
<form method="post" action="restore.php" enctype="multipart/form-data">
  <label>Upload File SQL:</label>
  <input type="file" name="sql_file" accept=".sql" required>
  <button type="submit">🔁 Restore</button>
</form>

<a href="../../index.php">← Kembali ke Dashboard</a>