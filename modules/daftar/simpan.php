<?php
include '../../config/db.php';

$nama = $_POST['nama'];
$tgl = $_POST['tanggal_lahir'];
$jabatan = $_POST['jabatan'];
$perusahaan = $_POST['perusahaan_id'];
$email = $_POST['email'];
$no_wa = $_POST['no_wa'];

$foto = '';
if ($_FILES['foto']['name']) {
  $foto = time().'_'.$_FILES['foto']['name'];
  move_uploaded_file($_FILES['foto']['tmp_name'], '../../assets/uploads/'.$foto);
}

$no_rm = 'MCU'.date('ymdHis');

mysqli_query($conn, "INSERT INTO pasien 
(nama, tanggal_lahir, jabatan, perusahaan_id, email, no_wa, foto, no_rm, tgl_mcu, status)
VALUES ('$nama', '$tgl', '$jabatan', '$perusahaan', '$email', '$no_wa', '$foto', '$no_rm', CURDATE(), 'Pending')");

echo "✅ Terima kasih, data Anda telah dikirim. Tunggu validasi dari pihak klinik.";