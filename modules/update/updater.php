<?php
$url = $_POST['url'] ?? '';
if (!$url) die("URL ZIP tidak ditemukan.");

$filename = 'update_' . time() . '.zip';
$destination = '../../temp/' . $filename;

file_put_contents($destination, fopen($url, 'r'));

echo "✅ File update berhasil diunduh ke: <b>$destination</b><br>";
echo "🔧 Silakan ekstrak manual dan timpa folder sesuai struktur proyek.<br>";
echo "<a href='index.php'>← Kembali</a>";