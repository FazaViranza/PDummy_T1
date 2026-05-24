<?php

session_start();

include '../koneksi.php';


// ========================
// CEK LOGIN
// ========================

if(!isset($_SESSION['admin'])) {

    header("Location: login.php");
    exit;

}


// ========================
// AMBIL DATA RESERVASI
// ========================

$sql = "
SELECT reservasi.*, stylist.nama_stylist
FROM reservasi

LEFT JOIN stylist
ON reservasi.id_stylist = stylist.id_stylist

ORDER BY id_reservasi DESC
";

$query = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>Dashboard Reservasi</h1>

        <a href="logout.php" class="btn btn-danger">

            Logout

        </a>

    </div>


    <div class="card shadow">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Kode Booking</th>
                        <th>Nama Pelanggan</th>
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
                            <?php echo $data['kode_booking']; ?>
                        </td>

                        <td>
                            <?php echo $data['nama_pelanggan']; ?>
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

                            <span class="badge bg-warning text-dark">

                                <?php echo $data['status_reservasi']; ?>

                            </span>

                        </td>

                        <td>

                            <a href="detail_reservasi.php?id=<?php echo $data['id_reservasi']; ?>"
                               class="btn btn-primary btn-sm">

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

</body>
</html>