<?php
require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include '../../config/db.php';

$pasien_id = $_POST['pasien_id'];
$email = $_POST['email'];
$link_pdf = "http://localhost/mcu-klinik/modules/cetak/pdf.php?pasien_id=$pasien_id";

$mail = new PHPMailer(true);
try {
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';  // ganti dengan SMTP host
  $mail->SMTPAuth = true;
  $mail->Username = 'youremail@gmail.com'; // ganti dengan email Anda
  $mail->Password = 'yourpassword';        // password/APP password Gmail
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $mail->setFrom('youremail@gmail.com', 'Klinik MCU');
  $mail->addAddress($email);

  $mail->isHTML(true);
  $mail->Subject = 'Hasil MCU Anda';
  $mail->Body = "Halo, silakan unduh hasil MCU Anda melalui link berikut:<br><a href='$link_pdf'>$link_pdf</a>";

  $mail->send();
  echo "✅ Email berhasil dikirim ke $email <br><a href='kirim.php?pasien_id=$pasien_id'>← Kembali</a>";
} catch (Exception $e) {
  echo "❌ Gagal kirim email. Error: {$mail->ErrorInfo}";
}