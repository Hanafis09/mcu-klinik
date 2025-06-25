<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");
?>

<h2>Data Pemeriksaan Audiometri & Spirometri</h2>
<table border="1" cellpadding="5" cellspacing="0">
  <tr>
    <th>No</th><th>Nama</th><th>Perusahaan</th><th>Tgl MCU</th><th>Aksi</th>
  </tr>
  <?php
  $no = 1;
  $q = mysqli_query($conn, "SELECT p.id, p.nama, pr.nama_perusahaan, p.tgl_mcu 
                            FROM pasien p 
                            LEFT JOIN perusahaan pr ON p.perusahaan_id = pr.id 
                            ORDER BY p.tgl_mcu DESC");
  while ($row = mysqli_fetch_assoc($q)) {
    echo "<tr>
      <td>$no</td>
      <td>{$row['nama']}</td>
      <td>{$row['nama_perusahaan']}</td>
      <td>{$row['tgl_mcu']}</td>
      <td><a href='form.php?pasien_id={$row['id']}'>Isi / Edit</a></td>
    </tr>";
    $no++;
  }
  ?>
</table>
<a href="../../index.php">← Kembali ke Dashboard</a>