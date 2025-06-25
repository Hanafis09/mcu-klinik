<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$tgl_dari = $_GET['dari'] ?? '';
$tgl_sampai = $_GET['sampai'] ?? '';

$where = "";
if ($tgl_dari && $tgl_sampai) {
  $where = "WHERE p.tgl_mcu BETWEEN '$tgl_dari' AND '$tgl_sampai'";
}
?>

<h2>Rekap Data MCU</h2>
<form method="get">
  Dari: <input type="date" name="dari" value="<?= $tgl_dari ?>">
  Sampai: <input type="date" name="sampai" value="<?= $tgl_sampai ?>">
  <button type="submit">Filter</button>
  <a href="export_excel.php?dari=<?= $tgl_dari ?>&sampai=<?= $tgl_sampai ?>" target="_blank">📥 Export Excel</a>
</form>

<table border="1" cellpadding="5" cellspacing="0">
  <tr>
    <th>No</th><th>Nama</th><th>Perusahaan</th><th>Tgl MCU</th><th>Rekam Medis</th>
  </tr>
  <?php
  $no = 1;
  $q = mysqli_query($conn, "
    SELECT p.*, pr.nama_perusahaan FROM pasien p 
    LEFT JOIN perusahaan pr ON p.perusahaan_id = pr.id 
    $where ORDER BY p.tgl_mcu DESC
  ");
  while ($row = mysqli_fetch_assoc($q)) {
    echo "<tr>
      <td>$no</td>
      <td>{$row['nama']}</td>
      <td>{$row['nama_perusahaan']}</td>
      <td>{$row['tgl_mcu']}</td>
      <td>{$row['no_rm']}</td>
    </tr>";
    $no++;
  }
  ?>
</table>

<a href="../../index.php">← Kembali ke Dashboard</a>