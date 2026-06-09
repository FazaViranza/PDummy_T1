<?php

session_start();

include '../koneksi.php';

if(!isset($_SESSION['admin'])) {

    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

/* =========================
   DATA RESERVASI
========================= */

$sqlReservasi = "
SELECT
    reservasi.*,
    stylist.nama_stylist,
    user.first_name,
    user.last_name,
    user.username

FROM reservasi

LEFT JOIN stylist
ON reservasi.id_stylist = stylist.id_stylist

LEFT JOIN user
ON reservasi.id_user = user.id_user

WHERE reservasi.id_reservasi = '$id'
";

$queryReservasi = mysqli_query($conn, $sqlReservasi);

$reservasi = mysqli_fetch_assoc($queryReservasi);


/* =========================
   DETAIL LAYANAN
========================= */

$sqlDetail = "
SELECT
    detail_reservasi.*,
    layanan.nama_layanan

FROM detail_reservasi

JOIN layanan
ON detail_reservasi.id_layanan = layanan.id_layanan

WHERE id_reservasi = '$id'
";

$queryDetail = mysqli_query($conn, $sqlDetail);

?>

<!DOCTYPE html>

<html>

<head>


<title>Detail Reservasi - Salon Sigma</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet">

<style>

    body{

        background:
        linear-gradient(
            180deg,
            #efe7dc 0%,
            #e5d8c7 50%,
            #d8c3a5 100%
        );

        min-height:100vh;

    }

    .navbar{

        background:rgba(20,20,20,0.85);

        backdrop-filter:blur(10px);

    }

    .page-title{

        font-size:48px;
        font-weight:800;

        color:#2c2c2c;

    }

    .glass-card{

        border:none;

        border-radius:25px;

        background:rgba(255,255,255,0.95);

        backdrop-filter:blur(10px);

        box-shadow:
        0 10px 30px rgba(0,0,0,0.08);

    }

    .booking-code{

        font-size:32px;

        font-weight:800;

        color:#c89b6d;
    }

    .info-label{

        font-size:13px;

        color:#888;

        text-transform:uppercase;

        margin-bottom:5px;
    }

    .info-value{

        font-weight:600;

        color:#222;
    }

    .proof-image{

        width:100%;

        max-height:700px;

        object-fit:contain;

        border-radius:15px;
    }

    .btn-validate{

        background:#198754;

        border:none;

        padding:12px 25px;
    }

    .btn-delete{

        padding:12px 25px;
    }

    .btn-back{

        background:#6c757d;

        border:none;

        padding:12px 25px;
    }

</style>


</head>

<body>

<nav class="navbar navbar-dark">


<div class="container">

    <span class="navbar-brand fw-bold">

        Salon Sigma Admin

    </span>

    <a href="dashboard.php"
       class="btn btn-outline-light">

        Dashboard

    </a>

</div>


</nav>

<div class="container py-5">


<a href="dashboard.php"
   class="btn btn-back text-white mb-4">

    ← Kembali

</a>

<h1 class="page-title mb-4">

    Detail Reservasi

</h1>


<!-- INFO RESERVASI -->

<div class="card glass-card mb-4">

    <div class="card-body p-5">

        <div class="booking-code mb-4">

            <?php echo $reservasi['kode_booking']; ?>

        </div>

        <div class="row">

            <div class="col-md-4 mb-4">

                <div class="info-label">

                    Nama User

                </div>

                <div class="info-value">

                    <?php
                    echo $reservasi['first_name'] .
                         ' ' .
                         $reservasi['last_name'];
                    ?>

                </div>

            </div>

            <div class="col-md-4 mb-4">

                <div class="info-label">

                    Username

                </div>

                <div class="info-value">

                    <?php echo $reservasi['username']; ?>

                </div>

            </div>

            <div class="col-md-4 mb-4">

                <div class="info-label">

                    Stylist

                </div>

                <div class="info-value">

                    <?php echo $reservasi['nama_stylist']; ?>

                </div>

            </div>

            <div class="col-md-4 mb-4">

                <div class="info-label">

                    Tanggal

                </div>

                <div class="info-value">

                    <?php echo $reservasi['tanggal_reservasi']; ?>

                </div>

            </div>

            <div class="col-md-4 mb-4">

                <div class="info-label">

                    Jam

                </div>

                <div class="info-value">

                    <?php echo $reservasi['jam_reservasi']; ?>

                </div>

            </div>

            <div class="col-md-4 mb-4">

                <div class="info-label">

                    Status

                </div>

                <div>

                    <?php if($reservasi['status_reservasi'] == 'Siap Datang') { ?>

                        <span class="badge bg-success">

                            Siap Datang

                        </span>

                    <?php } else { ?>

                        <span class="badge bg-warning text-dark">

                            Menunggu

                        </span>

                    <?php } ?>

                </div>

            </div>

            <div class="col-md-6">

                <div class="info-label">

                    Total Harga

                </div>

                <div class="info-value">

                    Rp <?php echo number_format($reservasi['total_harga']); ?>

                </div>

            </div>

            <div class="col-md-6">

                <div class="info-label">

                    DP

                </div>

                <div class="info-value">

                    Rp <?php echo number_format($reservasi['dp']); ?>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- LAYANAN -->

<div class="card glass-card mb-4">

    <div class="card-body p-4">

        <h3 class="mb-4">

            Layanan Dipilih

        </h3>

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th>Layanan</th>
                        <th>Qty</th>
                        <th>Subtotal</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($detail = mysqli_fetch_assoc($queryDetail)) { ?>

                    <tr>

                        <td>

                            <?php echo $detail['nama_layanan']; ?>

                        </td>

                        <td>

                            <?php echo $detail['qty']; ?>

                        </td>

                        <td>

                            Rp <?php echo number_format($detail['subtotal']); ?>

                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<!-- BUKTI -->

<div class="card glass-card mb-4">

    <div class="card-body p-4">

        <h3 class="mb-4">

            Bukti Pembayaran

        </h3>

        <img src="../uploads/<?php echo $reservasi['bukti_pembayaran']; ?>"
             class="proof-image">

    </div>

</div>


<!-- AKSI -->

<div class="card glass-card">

    <div class="card-body p-4">

        <h3 class="mb-4">

            Validasi Reservasi

        </h3>

        <div class="d-flex gap-2">

            <a href="validasi.php?id=<?php echo $reservasi['id_reservasi']; ?>"
               class="btn btn-success btn-validate">

                Validasi Reservasi

            </a>

            <a href="hapus_reservasi.php?id=<?php echo $reservasi['id_reservasi']; ?>"
               class="btn btn-danger btn-delete"
               onclick="return confirm('Yakin ingin menghapus reservasi ini?')">

                Hapus Reservasi

            </a>

        </div>

    </div>

</div>


</div>

</body>
</html>
