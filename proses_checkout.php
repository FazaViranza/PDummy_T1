<?php

session_start();
include 'koneksi.php';


// ========================
// AMBIL DATA FORM
// ========================

$nama_pelanggan   = $_POST['nama_pelanggan'];
$email             = $_POST['email'];
$no_hp             = $_POST['no_hp'];

$tanggal_reservasi = $_POST['tanggal_reservasi'];
$jam_reservasi     = $_POST['jam_reservasi'];

$id_stylist        = $_POST['id_stylist'];


// ========================
// HITUNG TOTAL
// ========================

$total_harga = 0;

foreach($_SESSION['cart'] as $id_layanan) {

    $sql = "SELECT * FROM layanan WHERE id_layanan = $id_layanan";

    $query = mysqli_query($conn, $sql);

    $data = mysqli_fetch_assoc($query);

    $total_harga += $data['harga'];
}


// ========================
// HITUNG DP
// ========================

$dp = $total_harga * 0.5;


// ========================
// UPLOAD BUKTI
// ========================

$nama_file = $_FILES['bukti_pembayaran']['name'];
$tmp_file  = $_FILES['bukti_pembayaran']['tmp_name'];

move_uploaded_file($tmp_file, "uploads/" . $nama_file);


// ========================
// GENERATE BOOKING CODE
// ========================

$kode_booking = "RSV" . rand(1000,9999);


// ========================
// INSERT RESERVASI
// ========================

$sqlReservasi = "
INSERT INTO reservasi
(
    nama_pelanggan,
    email,
    no_hp,
    tanggal_reservasi,
    jam_reservasi,
    total_harga,
    dp,
    status_reservasi,
    bukti_pembayaran,
    kode_booking,
    id_stylist
)
VALUES
(
    '$nama_pelanggan',
    '$email',
    '$no_hp',
    '$tanggal_reservasi',
    '$jam_reservasi',
    '$total_harga',
    '$dp',
    'Menunggu',
    '$nama_file',
    '$kode_booking',
    '$id_stylist'
)
";

mysqli_query($conn, $sqlReservasi);


// ========================
// AMBIL ID RESERVASI TERAKHIR
// ========================

$id_reservasi = mysqli_insert_id($conn);


// ========================
// INSERT DETAIL RESERVASI
// ========================

foreach($_SESSION['cart'] as $id_layanan) {

    $sql = "SELECT * FROM layanan WHERE id_layanan = $id_layanan";

    $query = mysqli_query($conn, $sql);

    $data = mysqli_fetch_assoc($query);

    $subtotal = $data['harga'];

    $sqlDetail = "
    INSERT INTO detail_reservasi
    (
        id_reservasi,
        id_layanan,
        qty,
        subtotal
    )
    VALUES
    (
        '$id_reservasi',
        '$id_layanan',
        1,
        '$subtotal'
    )
    ";

    mysqli_query($conn, $sqlDetail);
}


// ========================
// HAPUS CART
// ========================

unset($_SESSION['cart']);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Reservasi Berhasil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container py-5">

    <div class="alert alert-success">

        <h1>Reservasi Berhasil!</h1>

        <hr>

        <p>
            Kode Booking:
            <strong><?php echo $kode_booking; ?></strong>
        </p>

        <p>
            Total:
            <strong>
                Rp <?php echo number_format($total_harga); ?>
            </strong>
        </p>

        <p>
            DP:
            <strong>
                Rp <?php echo number_format($dp); ?>
            </strong>
        </p>

    </div>

    <div class="d-flex gap-2">

    <a href="index.php" class="btn btn-primary">

        Kembali ke Home

    </a>

    <a href="status.php" class="btn btn-dark">

        Cek Status Reservasi

    </a>

</div>

</div>

</body>
</html>