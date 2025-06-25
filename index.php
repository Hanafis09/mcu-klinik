<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard MCU Klinik</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        a { display: block; margin: 10px 0; color: teal; text-decoration: none; }
    </style>
</head>
<body>
    <h2>Selamat datang di MCU Klinik</h2>
    <p>Halo, <?php echo $_SESSION['username']; ?>! Pilih menu:</p>
    <ul>
        <li><a href="modules/pasien/list.php">🧍‍♂️ Data Pasien</a></li>
        <li><a href="modules/pemeriksaan_fisik/list.php">👩‍⚕️ Pemeriksaan Fisik</a></li>
        <li><a href="modules/lab/list.php">🧪 Laboratorium</a></li>
        <li><a href="modules/rekap/index.php">📋 Rekap MCU</a></li>
        <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
</body>
</html>
