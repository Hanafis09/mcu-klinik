<?php
require_once '../../vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorPNG;

$text = $_GET['text'] ?? 'ttd';
$generator = new BarcodeGeneratorPNG();
header('Content-Type: image/png');
echo $generator->getBarcode($text, $generator::TYPE_CODE_128);