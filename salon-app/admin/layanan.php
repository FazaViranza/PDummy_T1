<?php

session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin'])) {

    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM layanan ORDER BY id_layanan DESC";
$query = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html>

<head>


<title>Kelola Layanan - Salon Sigma</title>

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

    .table-card{

        border:none;

        border-radius:20px;

        overflow:hidden;

        background:white;

        box-shadow:
        0 10px 30px rgba(0,0,0,0.08);

    }

    .table thead{

        background:#1f1f1f;

        color:white;

    }

    .btn-add{

        background:#198754;

        border:none;

    }

    .btn-add:hover{

        background:#157347;

    }

    .btn-back{

        background:#6c757d;

        border:none;

    }

    .btn-edit{

        background:#c89b6d;

        border:none;

        color:white;
    }

    .btn-edit:hover{

        background:#b5885c;

        color:white;
    }

    .service-badge{

        background:#f8f3ed;

        color:#c89b6d;

        padding:6px 12px;

        border-radius:20px;

        font-size:12px;

        font-weight:600;
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


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="page-title">

            Kelola Layanan

        </h1>

        <p class="text-muted">

            Tambah, edit, dan hapus layanan salon

        </p>

    </div>

    <div>

        <a href="tambah_layanan.php"
           class="btn btn-add me-2">

            + Tambah Layanan

        </a>

        <a href="dashboard.php"
           class="btn btn-back">

            Kembali

        </a>

    </div>

</div>


<?php if(mysqli_num_rows($query) == 0) { ?>

    <div class="alert alert-info">

        Belum ada layanan.

    </div>

<?php } else { ?>

<div class="card table-card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Nama Layanan</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th width="180">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                <?php while($data = mysqli_fetch_assoc($query)) { ?>

                    <tr>

                        <td>

                            #<?php echo $data['id_layanan']; ?>

                        </td>

                        <td>

                            <strong>

                                <?php echo $data['nama_layanan']; ?>

                            </strong>

                        </td>

                        <td>

                            Rp <?php echo number_format($data['harga']); ?>

                        </td>

                        <td>

                            <span class="service-badge">

                                <?php echo $data['durasi_menit']; ?> Menit

                            </span>

                        </td>

                        <td>

                            <a href="edit_layanan.php?id=<?php echo $data['id_layanan']; ?>"
                               class="btn btn-edit btn-sm">

                                Edit

                            </a>

                            <a href="hapus_layanan.php?id=<?php echo $data['id_layanan']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus layanan ini?')">

                                Hapus

                            </a>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php } ?>


</div>

</body>
</html>
