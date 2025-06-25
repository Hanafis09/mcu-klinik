<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$pasien_id = $_GET['pasien_id'] ?? '';
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pasien WHERE id=$pasien_id"));
?>

<h2>Kirim Hasil MCU</h2>
<form method="post" action="send_email.php">
  <input type="hidden" name="pasien_id" value="<?= $pasien_id ?>">
  <label>Email:</label><br>
  <input type="email" name="email" value="<?= $data['email'] ?? '' ?>"><br>
  <button type="submit">📧 Kirim via Email</button>
</form>

<form method="post" action="send_whatsapp.php">
  <input type="hidden" name="pasien_id" value="<?= $pasien_id ?>">
  <label>No WhatsApp:</label><br>
  <input type="text" name="no_wa" value="<?= $data['no_wa'] ?? '' ?>"><br>
  <button type="submit">📱 Kirim via WhatsApp</button>
</form>

<a href="../review/view.php?pasien_id=<?= $pasien_id ?>">← Kembali</a>