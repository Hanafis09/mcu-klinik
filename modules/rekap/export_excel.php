<?php
require '../../vendor/autoload.php';
include '../../config/db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tgl_dari = $_GET['dari'] ?? '';
$tgl_sampai = $_GET['sampai'] ?? '';
$where = "";
if ($tgl_dari && $tgl_sampai) {
  $where = "WHERE p.tgl_mcu BETWEEN '$tgl_dari' AND '$tgl_sampai'";
}

$query = mysqli_query($conn, "
  SELECT p.*, pr.nama_perusahaan FROM pasien p 
  LEFT JOIN perusahaan pr ON p.perusahaan_id = pr.id 
  $where ORDER BY p.tgl_mcu DESC
");

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'Perusahaan');
$sheet->setCellValue('D1', 'Tanggal MCU');
$sheet->setCellValue('E1', 'No Rekam Medis');

$row = 2; $no = 1;
while ($data = mysqli_fetch_assoc($query)) {
  $sheet->setCellValue('A'.$row, $no++);
  $sheet->setCellValue('B'.$row, $data['nama']);
  $sheet->setCellValue('C'.$row, $data['nama_perusahaan']);
  $sheet->setCellValue('D'.$row, $data['tgl_mcu']);
  $sheet->setCellValue('E'.$row, $data['no_rm']);
  $row++;
}

$filename = "rekap_mcu_".date('Ymd').".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;