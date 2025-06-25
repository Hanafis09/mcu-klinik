<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$pasien_id = $_GET['pasien_id'] ?? '';
if (!$pasien_id) die("ID pasien tidak valid.");

$cek = mysqli_query($conn, "SELECT * FROM pemeriksaan_lab WHERE pasien_id=$pasien_id");
$data = mysqli_fetch_assoc($cek);

if (isset($_POST['simpan'])) {
  $fields = [
    'hb','leukosit','eritrosit','hematokrit','trombosit',
    'gula_darah','kolesterol_total','trigliserida','hdl','ldl',
    'urine_ph','protein_urine','glukosa_urine','kesimpulan'
  ];
  foreach ($fields as $f) {
    $$f = $_POST[$f] ?? null;
  }

  if ($data) {
    mysqli_query($conn, "UPDATE pemeriksaan_lab SET 
      hb='$hb', leukosit='$leukosit', eritrosit='$eritrosit', hematokrit='$hematokrit', trombosit='$trombosit',
      gula_darah='$gula_darah', kolesterol_total='$kolesterol_total', trigliserida='$trigliserida',
      hdl='$hdl', ldl='$ldl', urine_ph='$urine_ph', protein_urine='$protein_urine',
      glukosa_urine='$glukosa_urine', kesimpulan='$kesimpulan'
      WHERE pasien_id=$pasien_id");
  } else {
    mysqli_query($conn, "INSERT INTO pemeriksaan_lab 
      (pasien_id, hb, leukosit, eritrosit, hematokrit, trombosit, gula_darah, kolesterol_total, trigliserida, hdl, ldl,
       urine_ph, protein_urine, glukosa_urine, kesimpulan)
      VALUES 
      ($pasien_id, '$hb', '$leukosit', '$eritrosit', '$hematokrit', '$trombosit', '$gula_darah', '$kolesterol_total',
       '$trigliserida', '$hdl', '$ldl', '$urine_ph', '$protein_urine', '$glukosa_urine', '$kesimpulan')");
  }

  header("Location: list.php");
}
?>

<h2>Pemeriksaan Laboratorium</h2>
<form method="post">
  <h4>Hematologi</h4>
  <label>HB</label><input type="text" name="hb" value="<?= $data['hb'] ?? '' ?>"><br>
  <label>Leukosit</label><input type="text" name="leukosit" value="<?= $data['leukosit'] ?? '' ?>"><br>
  <label>Eritrosit</label><input type="text" name="eritrosit" value="<?= $data['eritrosit'] ?? '' ?>"><br>
  <label>Hematokrit</label><input type="text" name="hematokrit" value="<?= $data['hematokrit'] ?? '' ?>"><br>
  <label>Trombosit</label><input type="text" name="trombosit" value="<?= $data['trombosit'] ?? '' ?>"><br>

  <h4>Kimia Darah</h4>
  <label>Gula Darah</label><input type="text" name="gula_darah" value="<?= $data['gula_darah'] ?? '' ?>"><br>
  <label>Kolesterol Total</label><input type="text" name="kolesterol_total" value="<?= $data['kolesterol_total'] ?? '' ?>"><br>
  <label>Trigliserida</label><input type="text" name="trigliserida" value="<?= $data['trigliserida'] ?? '' ?>"><br>
  <label>HDL</label><input type="text" name="hdl" value="<?= $data['hdl'] ?? '' ?>"><br>
  <label>LDL</label><input type="text" name="ldl" value="<?= $data['ldl'] ?? '' ?>"><br>

  <h4>Urinalisa</h4>
  <label>pH Urine</label><input type="text" name="urine_ph" value="<?= $data['urine_ph'] ?? '' ?>"><br>
  <label>Protein Urine</label><input type="text" name="protein_urine" value="<?= $data['protein_urine'] ?? '' ?>"><br>
  <label>Glukosa Urine</label><input type="text" name="glukosa_urine" value="<?= $data['glukosa_urine'] ?? '' ?>"><br>

  <label>Kesimpulan</label><br>
  <textarea name="kesimpulan" rows="3"><?= $data['kesimpulan'] ?? '' ?></textarea><br>

  <button type="submit" name="simpan">💾 Simpan</button>
</form>
<a href="list.php">← Kembali</a>