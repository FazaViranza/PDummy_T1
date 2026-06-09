<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>

    <title>Keranjang - Salon Sigma</title>

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

        .page-title{

            font-size:52px;
            font-weight:800;

            color:#2c2c2c;

        }

        .cart-card{

            border:none;

            border-radius:20px;

            background:rgba(255,255,255,0.9);

            backdrop-filter:blur(10px);

            box-shadow:
            0 10px 30px rgba(0,0,0,0.08);

            transition:0.3s;

        }

        .cart-card:hover{

            transform:translateY(-5px);

        }

        .qty-btn{

            width:45px;

            font-weight:bold;

        }

        .summary-card{

            border:none;

            border-radius:20px;

            background:#1f1f1f;

            color:white;

            box-shadow:
            0 15px 35px rgba(0,0,0,0.2);

        }

        .empty-card{

            border:none;

            border-radius:20px;

        }

        .navbar{

            background:rgba(20,20,20,0.85);

            backdrop-filter:blur(10px);

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

        <a href="index.php"
           class="btn btn-outline-light">

            Home

        </a>

    </div>

</nav>

<div class="container py-5">

    <h1 class="page-title mb-2">

        Keranjang Saya

    </h1>

    <p class="text-muted mb-5">

        Review layanan yang akan Anda reservasi

    </p>

<?php

if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
?>

    <div class="card shadow empty-card">

        <div class="card-body text-center p-5">

            <h3 class="mb-3">

                Keranjang Kosong

            </h3>

            <p class="text-muted">

                Belum ada layanan yang dipilih.

            </p>

            <a href="index.php"
               class="btn btn-dark">

               Pilih Layanan

            </a>

        </div>

    </div>

<?php

} else {

    $total = 0;

?>

<div class="row">

    <div class="col-lg-8">

<?php

foreach($_SESSION['cart'] as $id_layanan => $qty) {

    $sql = "SELECT * FROM layanan WHERE id_layanan = $id_layanan";

    $query = mysqli_query($conn, $sql);

    $data = mysqli_fetch_assoc($query);

    $subtotal = $data['harga'] * $qty;

    $total += $subtotal;

?>

        <div class="card cart-card mb-4">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-md-6">

                        <h4 class="fw-bold">

                            <?php echo $data['nama_layanan']; ?>

                        </h4>

                        <p class="text-muted mb-0">

                            Durasi:
                            <?php echo $data['durasi_menit']; ?> menit

                        </p>

                    </div>

                    <div class="col-md-3 text-center">

                        <div class="d-flex justify-content-center gap-2">

                            <a href="kurang_cart.php?id=<?php echo $id_layanan; ?>"
                               class="btn btn-warning qty-btn">

                                -

                            </a>

                            <button class="btn btn-light">

                                <?php echo $qty; ?>

                            </button>

                            <a href="tambah_cart.php?id=<?php echo $id_layanan; ?>"
                               class="btn btn-success qty-btn">

                                +

                            </a>

                        </div>

                    </div>

                    <div class="col-md-3 text-end">

                        <small class="text-muted">

                            Subtotal

                        </small>

                        <h5 class="fw-bold">

                            Rp <?php echo number_format($subtotal); ?>

                        </h5>

                    </div>

                </div>

            </div>

        </div>

<?php } ?>

    </div>

    <div class="col-lg-4">

        <div class="card summary-card">

            <div class="card-body p-4">

                <h4 class="mb-4">

                    Ringkasan Pesanan

                </h4>

                <hr>

                <p>

                    Total Harga

                </p>

                <h3>

                    Rp <?php echo number_format($total); ?>

                </h3>

                <hr>

                <p>

                    DP (50%)

                </p>

                <h4>

                    Rp <?php echo number_format($total * 0.5); ?>

                </h4>

                <div class="d-grid gap-2 mt-4">

                    <a href="checkout.php"
                       class="btn btn-warning">

                        Checkout Sekarang

                    </a>

                    <a href="index.php"
                       class="btn btn-outline-light">

                        Tambah Layanan

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php } ?>

</div>

</body>
</html>