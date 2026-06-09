<?php

session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin'])) {

    header("Location: login.php");
    exit;
}

if(isset($_POST['simpan'])) {

    $nama_layanan = $_POST['nama_layanan'];
    $harga = $_POST['harga'];
    $durasi_menit = $_POST['durasi_menit'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file(
        $tmp,
        "../assets/" . $gambar
    );

    $sql = "
    INSERT INTO layanan
    (
        nama_layanan,
        harga,
        durasi_menit,
        deskripsi,
        gambar
    )
    VALUES
    (
        '$nama_layanan',
        '$harga',
        '$durasi_menit',
        '$deskripsi',
        '$gambar'
    )
    ";

    mysqli_query($conn, $sql);

    header("Location: layanan.php");
    exit;
}

?>

<!DOCTYPE html>

<html>

<head>


<title>Tambah Layanan - Salon Sigma</title>

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

    .btn-save{

        background:#198754;

        border:none;

        padding:12px 25px;
    }

    .btn-save:hover{

        background:#157347;

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

    <a href="layanan.php"
       class="btn btn-outline-light">

        Kelola Layanan

    </a>

</div>


</nav>

<div class="container py-5">


<h1 class="page-title mb-2">

    Tambah Layanan

</h1>

<p class="text-muted mb-5">

    Tambahkan layanan baru ke katalog salon

</p>

<div class="card form-card">

    <div class="card-body p-5">

        <form method="POST"
              enctype="multipart/form-data">

            <div class="mb-4">

                <label class="form-label">

                    Nama Layanan

                </label>

                <input
                    type="text"
                    name="nama_layanan"
                    class="form-control"
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
                    rows="4"></textarea>

            </div>

            <div class="mb-4">

                <label class="form-label">

                    Upload Gambar

                </label>

                <input
                    type="file"
                    name="gambar"
                    class="form-control">

            </div>

            <div class="d-flex gap-2">

                <button
                    type="submit"
                    name="simpan"
                    class="btn btn-save">

                    Simpan Layanan

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
