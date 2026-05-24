<?php

include '../koneksi.php';

$id = $_GET['id'];

$sql = "
UPDATE reservasi
SET status_reservasi = 'Siap Datang'
WHERE id_reservasi = '$id'
";

mysqli_query($conn, $sql);

header("Location: dashboard.php");
exit;

?>