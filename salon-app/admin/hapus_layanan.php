<?php

session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin'])) {

    header("Location: login.php");
    exit;

}

$id = $_GET['id'];

$sql = "
DELETE FROM layanan
WHERE id_layanan = '$id'
";

mysqli_query($conn, $sql);

header("Location: layanan.php");
exit;

?>