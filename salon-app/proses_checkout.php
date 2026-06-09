<?php

session_start();
include 'koneksi.php';

$id_user = $_SESSION['id_user'];

if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){

    header("Location: cart.php");
    exit;

}

// ========================
// AMBIL DATA FORM
// ========================

$tanggal_reservasi = $_POST['tanggal_reservasi'];
$jam_reservasi     = $_POST['jam_reservasi'];
$id_stylist        = $_POST['id_stylist'];

if($tanggal_reservasi == date('Y-m-d')){

    $jamSekarang = date('H:i');

    if($jam_reservasi < $jamSekarang){

        header("Location: checkout.php?error=Jam reservasi sudah lewat");
        exit;

    }

}

if($jam_reservasi < '09:00' || $jam_reservasi > '20:00'){

    header("Location: checkout.php?error=Jam reservasi hanya 09:00 - 20:00");
    exit;

}

if(empty($id_stylist)){

    header("Location: checkout.php?error=Silakan pilih stylist terlebih dahulu");
    exit;

}



// ========================
// HITUNG TOTAL
// ========================

$total_harga = 0;

foreach($_SESSION['cart'] as $id_layanan => $qty) {

    $sql = "SELECT * FROM layanan WHERE id_layanan = $id_layanan";

    $query = mysqli_query($conn, $sql);

    $data = mysqli_fetch_assoc($query);

    $total_harga += ($data['harga'] * $qty);
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

$allowed = ['jpg','jpeg','png'];

$ext = strtolower(
    pathinfo($nama_file, PATHINFO_EXTENSION)
);

if(!in_array($ext, $allowed)){

    header("Location: checkout.php?error=Bukti pembayaran harus JPG atau PNG");
    exit;

}

move_uploaded_file(
    $tmp_file,
    "uploads/" . $nama_file
);


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
    id_user,
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
    '$id_user',
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

foreach($_SESSION['cart'] as $id_layanan => $qty) {

    $sql = "SELECT * FROM layanan WHERE id_layanan = $id_layanan";

    $query = mysqli_query($conn, $sql);

    $data = mysqli_fetch_assoc($query);

    $subtotal = $data['harga'] * $qty;

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
        '$qty',
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

    <title>Reservasi Berhasil - Salon Sigma</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{

            min-height:100vh;

            background:
            linear-gradient(
                180deg,
                #efe7dc 0%,
                #e5d8c7 50%,
                #d8c3a5 100%
            );

            display:flex;
            align-items:center;
            justify-content:center;

            padding:30px;

        }

        .success-card{

            max-width:700px;
            width:100%;

            border:none;

            border-radius:25px;

            background:rgba(255,255,255,0.95);

            backdrop-filter:blur(10px);

            box-shadow:
            0 20px 50px rgba(0,0,0,0.12);

        }

        .success-icon{

            font-size:90px;

            color:#28a745;

            line-height:1;

        }

        .booking-code{

            font-size:32px;

            font-weight:800;

            color:#c89b6d;

            letter-spacing:2px;

        }

        .info-box{

            background:#f8f8f8;

            border-radius:15px;

            padding:20px;

        }

        .btn-home{

            background:#c89b6d;

            border:none;

            color:white;

            padding:12px 25px;

            border-radius:12px;

            font-weight:600;

        }

        .btn-home:hover{

            background:#b5885c;

            color:white;

        }

        .btn-status{

            background:#1f1f1f;

            border:none;

            color:white;

            padding:12px 25px;

            border-radius:12px;

            font-weight:600;

        }

        .btn-status:hover{

            background:#000;

            color:white;

        }

    </style>

</head>

<body>

<div class="card success-card">

    <div class="card-body p-5 text-center">

        <div class="success-icon">

            ✓

        </div>

        <h1 class="mt-3 fw-bold">

            Reservasi Berhasil!

        </h1>

        <p class="text-muted mb-4">

            Terima kasih telah melakukan reservasi di Salon Sigma.
            Reservasi Anda sedang menunggu validasi admin.

        </p>

        <div class="booking-code mb-4">

            <?php echo $kode_booking; ?>

        </div>

        <div class="info-box mb-4">

            <div class="row">

                <div class="col-md-6">

                    <h6>Total Reservasi</h6>

                    <h4>

                        Rp <?php echo number_format($total_harga); ?>

                    </h4>

                </div>

                <div class="col-md-6">

                    <h6>DP Dibayarkan</h6>

                    <h4>

                        Rp <?php echo number_format($dp); ?>

                    </h4>

                </div>

            </div>

        </div>

        <div class="alert alert-warning">

            Simpan kode booking Anda untuk pengecekan status reservasi.

        </div>

        <div class="d-flex justify-content-center gap-3 mt-4">

            <a href="index.php"
               class="btn btn-home">

                Kembali ke Home

            </a>

            <a href="status.php"
               class="btn btn-status">

                Cek Status Reservasi

            </a>

        </div>

    </div>

</div>

</body>
</html>