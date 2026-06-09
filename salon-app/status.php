<?php

session_start();
include 'koneksi.php';

if(!isset($_SESSION['id_user'])){

    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$sql = "
SELECT *
FROM reservasi
WHERE id_user = '$id_user'
ORDER BY id_reservasi DESC
";

$query = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Reservasi Saya - Salon Sigma</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

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

            font-size:52px;
            font-weight:800;

            color:#2c2c2c;

        }

        .reservation-card{

            border:none;

            border-radius:20px;

            background:rgba(255,255,255,0.92);

            backdrop-filter:blur(10px);

            box-shadow:
            0 10px 30px rgba(0,0,0,0.08);

            transition:0.3s;

        }

        .reservation-card:hover{

            transform:translateY(-5px);

        }

        .booking-code{

            font-size:24px;
            font-weight:bold;

            color:#c89b6d;

        }

        .empty-card{

            border:none;

            border-radius:20px;

        }

    </style>

</head>

<body>

<nav class="navbar navbar-dark">

    <div class="container">

        <a href="index.php"
           class="navbar-brand fw-bold">

            Salon Sigma

        </a>

        <div>

            <span class="text-white me-3">

                Halo,
                <?php echo $_SESSION['first_name']; ?>

            </span>

            <a href="index.php"
               class="btn btn-outline-light">

                Home

            </a>

        </div>

    </div>

</nav>

<div class="container py-5">

    <h1 class="page-title mb-2">

        Reservasi Saya

    </h1>

    <p class="text-muted mb-5">

        Riwayat dan status reservasi Anda

    </p>

<?php if(mysqli_num_rows($query) == 0) { ?>

    <div class="card shadow empty-card">

        <div class="card-body text-center p-5">

            <h3>

                Belum Ada Reservasi

            </h3>

            <p class="text-muted">

                Anda belum memiliki reservasi salon.

            </p>

            <a href="index.php"
               class="btn btn-dark">

                Booking Sekarang

            </a>

        </div>

    </div>

<?php } else { ?>

    <?php while($data = mysqli_fetch_assoc($query)) { ?>

        <div class="card reservation-card mb-4">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <div class="booking-code">

                            <?php echo $data['kode_booking']; ?>

                        </div>

                        <small class="text-muted">

                            Booking Code

                        </small>

                    </div>

                    <div>

                        <?php

                        if($data['status_reservasi'] == 'Siap Datang') {

                            echo "
                            <span class='badge bg-success fs-6'>
                                Siap Datang
                            </span>
                            ";

                        } else {

                            echo "
                            <span class='badge bg-warning text-dark fs-6'>
                                Menunggu
                            </span>
                            ";

                        }

                        ?>

                    </div>

                </div>

                <hr>

                <div class="row">

                    <div class="col-md-4">

                        <strong>Tanggal</strong>

                        <p>

                            <?php echo $data['tanggal_reservasi']; ?>

                        </p>

                    </div>

                    <div class="col-md-4">

                        <strong>Jam</strong>

                        <p>

                            <?php echo $data['jam_reservasi']; ?>

                        </p>

                    </div>

                    <div class="col-md-4">

                        <strong>Total</strong>

                        <p>

                            Rp <?php echo number_format($data['total_harga']); ?>

                        </p>

                    </div>

                </div>

            </div>

        </div>

    <?php } ?>

<?php } ?>

    <a href="index.php"
       class="btn btn-dark">

        ← Kembali ke Home

    </a>

</div>

</body>
</html>