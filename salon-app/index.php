<?php
session_start();

include 'koneksi.php';

if(isset($_GET['search'])){

    $search = $_GET['search'];

    $sql = "
    SELECT *
    FROM layanan
    WHERE nama_layanan LIKE '%$search%'
    ";

} else {

    $sql = "SELECT * FROM layanan";

}

$query = mysqli_query($conn, $sql);

$jumlah_cart = isset($_SESSION['cart'])
    ? array_sum($_SESSION['cart'])
    : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Salon Sigma</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{

            background:#111;
        }

        .navbar{

            position:fixed;
            top:0;
            width:100%;
            z-index:1000;

            background:rgba(10,10,10,0.55);

            backdrop-filter:blur(12px);
            -webkit-backdrop-filter:blur(12px);

            border-bottom:1px solid rgba(255,255,255,0.08);

        }

        .hero{

            position:relative;

            min-height:100vh;

            display:flex;
            align-items:center;
            justify-content:center;

            background:
            linear-gradient(
                rgba(0,0,0,0.65),
                rgba(0,0,0,0.65)
            ),
            url('assets/hero.jpg');

            background-size:cover;
            background-position:center;

            color:white;

        }

        .hero::after{

            content:"";

            position:absolute;

            bottom:0;
            left:0;

            width:100%;
            height:200px;

            background:linear-gradient(
                transparent,
                #efe7dc
            );

            pointer-events:none;

        }

        .hero-content{

            text-align:center;

        }

        .hero-stats{

            margin-top:60px;

        }

        .hero-stats h3{

            font-weight:bold;
        }

        .hero-stats p{

            margin-bottom:0;
            opacity:0.9;
        }

       #layanan{

            background:
            linear-gradient(
                180deg,
                #efe7dc 0%,
                #e5d8c7 50%,
                #d8c3a5 100%
            );

            min-height:100vh;

            padding-top:100px;
            padding-bottom:100px;
        }

        .service-card{

            background:#fff;

            box-shadow:
            0 10px 30px rgba(0,0,0,0.08);

            backdrop-filter:blur(5px);

            border:none;

            border-radius:20px;
        }

        .service-card:hover{

            transform:translateY(-10px);

            box-shadow:
            0 20px 40px rgba(0,0,0,0.15);
        }

        .service-image{

            height:250px;

            object-fit:cover;
        }

        .search-card{

            border:none;

            border-radius:20px;
        }

        footer{

            background:#1f1f1f;

            color:white;
        }

    </style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar navbar-expand-lg navbar-dark">

    <div class="container">

        <a class="navbar-brand fw-bold"
           href="index.php">

            Salon Sigma

        </a>

        <div>

            <a href="index.php"
               class="btn btn-outline-light btn-sm me-2">

                Home

            </a>

            <a href="cart.php"
               class="btn btn-outline-light btn-sm me-2">

                Keranjang
                (<?php echo $jumlah_cart; ?>)

            </a>

            <?php if(isset($_SESSION['id_user'])) { ?>

                <a href="status.php"
                   class="btn btn-outline-info btn-sm me-2">

                    Reservasi Saya

                </a>

                <span class="text-white me-2">

                    Halo,
                    <?php echo $_SESSION['first_name']; ?>

                </span>

                <a href="logout.php"
                   class="btn btn-danger btn-sm">

                    Logout

                </a>

            <?php } else { ?>

                <a href="login.php"
                   class="btn btn-success btn-sm me-2">

                    Login

                </a>

                <a href="register.php"
                   class="btn btn-warning btn-sm">

                    Register

                </a>

            <?php } ?>

        </div>

    </div>

</nav>


<!-- HERO -->

<section class="hero">

    <div class="container">

        <div class="hero-content">

            <h1 class="display-1 fw-bold">

                Salon Sigma

            </h1>

            <p class="fs-2">

                Premium Hair & Beauty Experience

            </p>

            <p class="lead">

                Reservasi online dengan stylist profesional

            </p>

            <a href="#layanan"
               class="btn btn-warning btn-lg px-5 mt-3">

                Booking Sekarang

            </a>

            <div class="row hero-stats justify-content-center text-center">

                <div class="col-md-2">

                    <h3>500+</h3>

                    <p>Pelanggan</p>

                </div>

                <div class="col-md-2">

                    <h3>10+</h3>

                    <p>Stylist</p>

                </div>

                <div class="col-md-2">

                    <h3>24/7</h3>

                    <p>Reservasi</p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- KATALOG -->

<section id="layanan">

    <div class="container py-5">

    <div class="text-center mb-5">

        <h2 class="fw-bold">

            Our Services

        </h2>

        <p class="text-muted">

            Pilih layanan terbaik untuk kebutuhan Anda

        </p>

    </div>


    <!-- SEARCH -->

    <div class="card shadow search-card mb-5">

        <div class="card-body p-4">

            <form method="GET">

                <div class="input-group">

                    <input type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari layanan..."
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

                    <button class="btn btn-dark">

                        Search

                    </button>

                </div>

            </form>

        </div>

    </div>


    <!-- CARD LAYANAN -->

    <div class="row">

        <?php while($data = mysqli_fetch_assoc($query)) { ?>

            <div class="col-md-6 col-lg-4 mb-4">

                <div class="card shadow service-card h-100">

                    <?php if(!empty($data['gambar'])) { ?>

                        <img src="assets/<?php echo $data['gambar']; ?>"
                             class="card-img-top service-image">

                    <?php } else { ?>

                        <img src="https://via.placeholder.com/600x400?text=Salon+Sigma"
                             class="card-img-top service-image">

                    <?php } ?>

                    <div class="card-body d-flex flex-column">

                        <h4>

                            <?php echo $data['nama_layanan']; ?>

                        </h4>

                        <h5 class="text-primary">

                            Rp <?php echo number_format($data['harga']); ?>

                        </h5>

                        <p>

                            Durasi:
                            <?php echo $data['durasi_menit']; ?> menit

                        </p>

                        <p class="flex-grow-1">

                            <?php echo $data['deskripsi']; ?>

                        </p>

                        <a href="tambah_cart.php?id=<?php echo $data['id_layanan']; ?>"
                           class="btn btn-dark w-100">

                            Tambah ke Keranjang

                        </a>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

</section>




<!-- FOOTER -->

<footer class="text-center py-5">

    <h4 class="fw-bold">

        Salon Sigma

    </h4>

    <p>

        Premium Hair & Beauty Experience

    </p>

    <small>

        © 2026 Salon Sigma. All Rights Reserved.

    </small>

</footer>

</body>
</html>