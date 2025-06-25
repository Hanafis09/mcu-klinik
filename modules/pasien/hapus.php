<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM pasien WHERE id=$id");
header("Location: list.php");
