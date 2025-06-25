<?php
include '../../config/db.php';
$perusahaan = mysqli_query($conn, "SELECT * FROM perusahaan");
?>

<h2>Pendaftaran Medical Check Up</h2>
<form method="post" action="simpan.php" enctype="multipart/form-data">
  <label>Nama:</label><br>
  <input type="text" name="nama" required><br>

  <label>Tanggal Lahir:</label><br>
  <input type="date" name="tanggal_lahir" required><br>

  <label>Jabatan:</label><br>
  <input type="text" name="jabatan"><br>

  <label>Perusahaan:</label><br>
  <select name="perusahaan_id" required>
    <option value="">- Pilih -</option>
    <?php while($p = mysqli_fetch_assoc($perusahaan)) {
      echo "<option value='{$p['id']}'>{$p['nama_perusahaan']}</option>";
    } ?>
  </select><br>

  <label>Email:</label><br>
  <input type="email" name="email"><br>

  <label>No WhatsApp:</label><br>
  <input type="text" name="no_wa"><br>

  <label>Foto 4x6:</label><br>
  <input type="file" name="foto"><br><br>

  <button type="submit">📨 Daftar</button>
</form>