<?php
include '../../config/db.php';
$id = $_GET['id'];
mysqli_query($conn, "UPDATE pasien SET status='Disetujui' WHERE id=$id");
header("Location: ../pasien/list.php");