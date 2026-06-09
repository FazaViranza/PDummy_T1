<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id_user'])){

    header("Location: login.php");
    exit;
}

$sqlStylist = "SELECT * FROM stylist";
$queryStylist = mysqli_query($conn, $sqlStylist);

$error = "";

if(isset($_GET['error'])){

    $error = $_GET['error'];

}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Checkout - Salon Sigma</title>

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

        .checkout-card{

            border:none;

            border-radius:20px;

            background:rgba(255,255,255,0.92);

            backdrop-filter:blur(10px);

            box-shadow:
            0 10px 30px rgba(0,0,0,0.08);

        }

        .form-control,
        .form-select{

            border-radius:12px;

            padding:12px;

        }

        .form-control:focus,
        .form-select:focus{

            border-color:#c89b6d;

            box-shadow:none;

        }

        .qris-image{

            max-width:320px;

            border-radius:20px;

            box-shadow:
            0 10px 25px rgba(0,0,0,0.15);

        }

        .btn-book{

            background:#c89b6d;

            color:white;

            border:none;

            border-radius:12px;

            padding:15px;

            font-weight:600;

        }

        .btn-book:hover{

            background:#b5885c;

            color:white;

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

            <a href="cart.php"
               class="btn btn-outline-light me-2">

                Keranjang

            </a>

            <a href="index.php"
               class="btn btn-outline-light">

                Home

            </a>

        </div>

    </div>

</nav>

<div class="container py-5">

    <h1 class="page-title mb-2">

        Checkout Reservasi

    </h1>

    <p class="text-muted mb-5">

        Lengkapi reservasi dan pembayaran Anda

    </p>

    <?php if($error != "") { ?>

        <div class="alert alert-danger">

            <?php echo htmlspecialchars($error); ?>

        </div>

    <?php } ?>

    <div class="alert alert-light border shadow-sm">

        Login sebagai:

        <strong>

            <?php echo $_SESSION['first_name']; ?>

        </strong>

    </div>

    <form action="proses_checkout.php"
          method="POST"
          enctype="multipart/form-data">

        <!-- JADWAL -->

        <div class="card checkout-card mb-4">

            <div class="card-body p-4">

                <h3 class="mb-4">

                    Jadwal Reservasi

                </h3>

                <div class="mb-3">

                    <label class="form-label">

                        Tanggal Reservasi

                    </label>

                    <input
                        type="date"
                        name="tanggal_reservasi"
                        class="form-control"
                        min="<?php echo date('Y-m-d'); ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Jam Reservasi

                    </label>

                    <input
                        type="time"
                        name="jam_reservasi"
                        class="form-control"
                        required>

                </div>

            </div>

        </div>


        <!-- STYLIST -->

        <div class="card checkout-card mb-4">

            <div class="card-body p-4">

                <h3 class="mb-4">

                    Pilih Stylist

                </h3>

                <select
                    name="id_stylist"
                    class="form-select">

                    <option value="">

                        -- Pilih Stylist --

                    </option>

                    <?php while($stylist = mysqli_fetch_assoc($queryStylist)) { ?>

                        <option value="<?php echo $stylist['id_stylist']; ?>">

                            <?php echo $stylist['nama_stylist']; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

        </div>


        <!-- PEMBAYARAN -->

        <div class="card checkout-card mb-4">

            <div class="card-body p-4 text-center">

                <h3 class="mb-4">

                    Pembayaran DP

                </h3>

                <p>

                    Silakan melakukan pembayaran DP sebesar

                    <strong>50%</strong>

                    melalui QRIS berikut

                </p>

                <img src="assets/qris1.png"
                     class="img-fluid qris-image mb-4">

                <hr>

                <p>

                    Atau transfer ke:

                </p>

                <ul class="list-unstyled">

                    <li>

                        Bank BCA - 1234567890

                    </li>

                    <li>

                        a.n Salon Sigma

                    </li>

                </ul>

            </div>

        </div>


        <!-- BUKTI -->

        <div class="card checkout-card mb-4">

            <div class="card-body p-4">

                <h3 class="mb-4">

                    Upload Bukti Pembayaran

                </h3>

                <input
                    type="file"
                    name="bukti_pembayaran"
                    class="form-control"
                    required>

            </div>

        </div>


        <button
            type="submit"
            class="btn btn-book w-100">

            Konfirmasi Reservasi

        </button>

    </form>

</div>

</body>
</html>