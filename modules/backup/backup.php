<?php
include '../../config/db.php';

$nama_file = "backup_mcu_" . date("Ymd_His") . ".sql";
$path = "../../modules/backup/uploads/" . $nama_file;

exec("mysqldump -u root mcu_klinik > $path"); // Ganti 'root' & 'mcu_klinik' sesuai nama user & DB

header("Content-Disposition: attachment; filename=" . $nama_file);
header("Content-Type: application/octet-stream");
readfile($path);
exit;