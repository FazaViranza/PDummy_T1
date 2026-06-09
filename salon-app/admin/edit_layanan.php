<?php

session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin'])) {

    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM layanan WHERE id_layanan = '$id'";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])) {

    $nama_layanan = $_POST['nama_layanan'];
    $harga = $_POST['harga'];
    $durasi_menit = $_POST['durasi_menit'];
    $deskripsi = $_POST['deskripsi'];

    $sqlUpdate = "
    UPDATE layanan
    SET
        nama_layanan = '$nama_layanan',
        harga = '$harga',
        durasi_menit = '$durasi_menit',
        deskripsi = '$deskripsi'
    WHERE id_layanan = '$id'
    ";

    mysqli_query($conn, $sqlUpdate);

    header("Location: layanan.php");
    exit;
}

?>

<!DOCTYPE html>

<html>

<head>


<title>Edit Layanan - Salon Sigma</title>

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

        font-size:52px;
        font-weight:800;

        color:#2c2c2c;

    }

    .form-card{

        border:none;

        border-radius:25px;

        background:rgba(255,255,255,0.95);

        backdrop-filter:blur(10px);

        box-shadow:
        0 10px 30px rgba(0,0,0,0.08);

    }

    .form-control{

        border-radius:12px;

        padding:12px;

    }

    .form-control:focus{

        border-color:#c89b6d;

        box-shadow:none;

    }

    .btn-update{

        background:#c89b6d;

        border:none;

        color:white;

        padding:12px 25px;
    }

    .btn-update:hover{

        background:#b5885c;

        color:white;
    }

    .btn-back{

        background:#6c757d;

        border:none;

        padding:12px 25px;
    }

    .preview-card{

        background:#f8f3ed;

        border-radius:15px;

        padding:15px;

        margin-bottom:25px;
    }

</style>


</head>

<body>

<nav class="navbar navbar-dark">


<div class="container">

    <span class="navbar-brand fw-bold">

        Salon Sigma Admin

    </span>

    <a href="layanan.php"
       class="btn btn-outline-light">

        Kelola Layanan

    </a>

</div>


</nav>

<div class="container py-5">


<h1 class="page-title mb-2">

    Edit Layanan

</h1>

<p class="text-muted mb-5">

    Perbarui informasi layanan salon

</p>

<div class="card form-card">

    <div class="card-body p-5">

        <div class="preview-card">

            <strong>ID Layanan:</strong>

            #<?php echo $data['id_layanan']; ?>

        </div>

        <form method="POST">

            <div class="mb-4">

                <label class="form-label">

                    Nama Layanan

                </label>

                <input
                    type="text"
                    name="nama_layanan"
                    class="form-control"
                    value="<?php echo $data['nama_layanan']; ?>"
                    required>

            </div>

            <div class="row">

                <div class="col-md-6 mb-4">

                    <label class="form-label">

                        Harga

                    </label>

                    <input
                        type="number"
                        name="harga"
                        class="form-control"
                        value="<?php echo $data['harga']; ?>"
                        required>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="form-label">

                        Durasi (Menit)

                    </label>

                    <input
                        type="number"
                        name="durasi_menit"
                        class="form-control"
                        value="<?php echo $data['durasi_menit']; ?>"
                        required>

                </div>

            </div>

            <div class="mb-4">

                <label class="form-label">

                    Deskripsi

                </label>

                <textarea
                    name="deskripsi"
                    class="form-control"
                    rows="4"><?php echo $data['deskripsi']; ?></textarea>

            </div>

            <div class="d-flex gap-2">

                <button
                    type="submit"
                    name="update"
                    class="btn btn-update">

                    Update Layanan

                </button>

                <a href="layanan.php"
                   class="btn btn-back">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>


</div>

</body>
</html>
