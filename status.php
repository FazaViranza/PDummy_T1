<?php
include 'koneksi.php';

$data = null;

if(isset($_POST['cek'])) {

    $kode_booking = $_POST['kode_booking'];
    $no_hp = $_POST['no_hp'];

    $sql = "
    SELECT *
    FROM reservasi
    WHERE kode_booking = '$kode_booking'
    AND no_hp = '$no_hp'
    ";

    $query = mysqli_query($conn, $sql);

    $data = mysqli_fetch_assoc($query);
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Cek Status Reservasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow mb-4">

                <div class="card-body">

                    <h2 class="text-center mb-4">

                        Cek Status Reservasi

                    </h2>

                    <form method="POST">

                        <div class="mb-3">

                            <label>Kode Booking</label>

                            <input type="text"
                                   name="kode_booking"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label>Nomor HP</label>

                            <input type="text"
                                   name="no_hp"
                                   class="form-control"
                                   required>

                        </div>

                        <button type="submit"
                                name="cek"
                                class="btn btn-dark w-100">

                            Cek Status

                        </button>

                    </form>

                </div>

            </div>


            <?php if($data) { ?>

                <div class="card shadow">

                    <div class="card-body">

                        <h3 class="mb-3">

                            Detail Reservasi

                        </h3>

                        <p>
                            <strong>Nama:</strong>
                            <?php echo $data['nama_pelanggan']; ?>
                        </p>

                        <p>
                            <strong>Tanggal:</strong>
                            <?php echo $data['tanggal_reservasi']; ?>
                        </p>

                        <p>
                            <strong>Jam:</strong>
                            <?php echo $data['jam_reservasi']; ?>
                        </p>

                        <p>
                            <strong>Status:</strong>

                            <?php

                            if($data['status_reservasi'] == 'Siap Datang') {

                                echo "<span class='badge bg-success'>Siap Datang</span>";

                            } else {

                                echo "<span class='badge bg-warning text-dark'>Menunggu</span>";

                            }

                            ?>

                        </p>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</div>

</body>
</html>