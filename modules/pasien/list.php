<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");
?>

<h2>Daftar Pasien</h2>
<a href="form.php">+ Tambah Pasien</a>
<table border="1" cellpadding="5" cellspacing="0">
  <tr>
    <th>No</th>
    <th>Foto</th>
    <th>Nama</th>
    <th>Jabatan</th>
    <th>Perusahaan</th>
    <th>Tgl MCU</th>
    <th>Status</th>
    <th>Aksi</th>
  </tr>
  <?php
  $no = 1;
  $q = mysqli_query($conn, "SELECT pasien.*, perusahaan.nama_perusahaan FROM pasien 
                            LEFT JOIN perusahaan ON pasien.perusahaan_id = perusahaan.id");
  while ($row = mysqli_fetch_assoc($q)) {
    echo "<tr>
      <td>$no</td>
      <td><img src='../../assets/uploads/{$row['foto']}' width='40'></td>
      <td>{$row['nama']}</td>
      <td>{$row['jabatan']}</td>
      <td>{$row['nama_perusahaan']}</td>
      <td>{$row['tgl_mcu']}</td>
      <td>{$row['status']}</td>
      <td>";

    // Tampilkan tombol validasi hanya jika statusnya masih Pending
    if ($row['status'] == 'Pending') {
      echo "<a href='../daftar/validasi.php?id={$row['id']}'>✔️ Validasi</a> | ";
    } else {
      echo "✅ Disetujui | ";
    }

    echo "<a href='form.php?id={$row['id']}'>Edit</a> |
          <a href='hapus.php?id={$row['id']}' onclick=\"return confirm('Hapus?')\">Hapus</a>
      </td>
    </tr>";
    $no++;
  }
  ?>
</table>
<a href="../../index.php">← Kembali ke Dashboard</a>