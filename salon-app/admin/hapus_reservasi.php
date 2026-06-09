<?php

session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin'])) {

    header("Location: login.php");
    exit;

}

$id = $_GET['id'];


// ========================
// HAPUS DETAIL DULU
// ========================

mysqli_query(
    $conn,
    "DELETE FROM detail_reservasi
     WHERE id_reservasi = '$id'"
);


// ========================
// HAPUS RESERVASI
// ========================

mysqli_query(
    $conn,
    "DELETE FROM reservasi
     WHERE id_reservasi = '$id'"
);


header("Location: dashboard.php");
exit;

?>