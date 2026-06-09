<?php

session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin'])) {

    header("Location: login.php");
    exit;
}

/* =========================
   STATISTIK
========================= */

$totalReservasi = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM reservasi"
    )
)['total'];

$totalMenunggu = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM reservasi
         WHERE status_reservasi='Menunggu'"
    )
)['total'];

$totalSiap = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM reservasi
         WHERE status_reservasi='Siap Datang'"
    )
)['total'];

$totalStylist = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM stylist"
    )
)['total'];


/* =========================
   DATA RESERVASI
========================= */

$sql = "
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

ORDER BY reservasi.id_reservasi DESC
";

$query = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Dashboard Admin - Salon Sigma</title>

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

        .stat-card{

            border:none;

            border-radius:20px;

            background:rgba(255,255,255,0.92);

            backdrop-filter:blur(10px);

            box-shadow:
            0 10px 30px rgba(0,0,0,0.08);

            transition:0.3s;

        }

        .stat-card:hover{

            transform:translateY(-5px);

        }

        .stat-number{

            font-size:36px;

            font-weight:800;

            color:#c89b6d;

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

        .btn-detail{

            background:#c89b6d;

            border:none;

            color:white;

        }

        .btn-detail:hover{

            background:#b5885c;

            color:white;

        }

    </style>

</head>

<body>

<nav class="navbar navbar-dark">

    <div class="container">

        <span class="navbar-brand fw-bold">

            Salon Sigma Admin

        </span>

        <div>

            <a href="layanan.php"
               class="btn btn-success me-2">

                Kelola Layanan

            </a>

            <a href="logout.php"
               class="btn btn-danger">

                Logout

            </a>

        </div>

    </div>

</nav>

<div class="container py-5">

    <h1 class="page-title mb-2">

        Dashboard Admin

    </h1>

    <p class="text-muted mb-5">

        Monitoring reservasi dan aktivitas salon

    </p>


    <!-- STATISTIK -->

    <div class="row mb-5">

        <div class="col-md-3 mb-3">

            <div class="card stat-card">

                <div class="card-body text-center">

                    <div class="stat-number">

                        <?php echo $totalReservasi; ?>

                    </div>

                    <h6>Total Reservasi</h6>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card stat-card">

                <div class="card-body text-center">

                    <div class="stat-number">

                        <?php echo $totalMenunggu; ?>

                    </div>

                    <h6>Menunggu Validasi</h6>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card stat-card">

                <div class="card-body text-center">

                    <div class="stat-number">

                        <?php echo $totalSiap; ?>

                    </div>

                    <h6>Siap Datang</h6>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card stat-card">

                <div class="card-body text-center">

                    <div class="stat-number">

                        <?php echo $totalStylist; ?>

                    </div>

                    <h6>Total Stylist</h6>

                </div>

            </div>

        </div>

    </div>


    <?php if(mysqli_num_rows($query) == 0) { ?>

        <div class="alert alert-info">

            Belum ada reservasi.

        </div>

    <?php } else { ?>

    <div class="card table-card">

        <div class="card-body">

            <h4 class="mb-4">

                Daftar Reservasi

            </h4>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Kode</th>
                            <th>Nama User</th>
                            <th>Username</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Stylist</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php while($data = mysqli_fetch_assoc($query)) { ?>

                        <tr>

                            <td>

                                <strong>

                                    <?php echo $data['kode_booking']; ?>

                                </strong>

                            </td>

                            <td>

                                <?php

                                $namaUser = trim(
                                    ($data['first_name'] ?? '') .
                                    ' ' .
                                    ($data['last_name'] ?? '')
                                );

                                echo $namaUser ?: 'User Tidak Diketahui';

                                ?>

                            </td>

                            <td>

                                <?php echo $data['username'] ?? '-'; ?>

                            </td>

                            <td>

                                <?php echo $data['tanggal_reservasi']; ?>

                            </td>

                            <td>

                                <?php echo $data['jam_reservasi']; ?>

                            </td>

                            <td>

                                <?php echo $data['nama_stylist']; ?>

                            </td>

                            <td>

                                Rp <?php echo number_format($data['total_harga']); ?>

                            </td>

                            <td>

                                <?php if($data['status_reservasi'] == 'Siap Datang') { ?>

                                    <span class="badge bg-success">

                                        Siap Datang

                                    </span>

                                <?php } else { ?>

                                    <span class="badge bg-warning text-dark">

                                        Menunggu

                                    </span>

                                <?php } ?>

                            </td>

                            <td>

                                <a href="detail_reservasi.php?id=<?php echo $data['id_reservasi']; ?>"
                                   class="btn btn-detail btn-sm">

                                    Detail

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