<?php
$no_wa = $_POST['no_wa'];
$pasien_id = $_POST['pasien_id'];
$link = "http://localhost/mcu-klinik/modules/cetak/pdf.php?pasien_id=$pasien_id";

$pesan = urlencode("Halo, ini adalah hasil MCU Anda. Silakan unduh: $link");

// Contoh WA Gateway lokal (ganti sesuai server WA Gateway Anda)
$wa_link = "https://api.whatsappgateway.local/send?phone=$no_wa&text=$pesan";

// Redirect otomatis ke WA Gateway
header("Location: $wa_link");