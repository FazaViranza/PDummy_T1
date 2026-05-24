<?php
session_start();
include 'koneksi.php';

$sqlStylist = "SELECT * FROM stylist";
$queryStylist = mysqli_query($conn, $sqlStylist);
?>

<!DOCTYPE html>
<html>
<head>

    <title>Checkout</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container py-5">

    <h1 class="mb-4">Checkout Reservasi</h1>

    <form action="proses_checkout.php" method="POST" enctype="multipart/form-data">

        <!-- DATA DIRI -->
        <div class="card mb-4">
            <div class="card-body">

                <h3>Data Diri</h3>

                <div class="mb-3">
                    <label>Nama Lengkap</label>

                    <input type="text"
                           name="nama_pelanggan"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Email</label>

                    <input type="email"
                           name="email"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Nomor HP</label>

                    <input type="text"
                           name="no_hp"
                           class="form-control"
                           required>
                </div>

            </div>
        </div>


        <!-- JADWAL -->
        <div class="card mb-4">
            <div class="card-body">

                <h3>Jadwal Reservasi</h3>

                <div class="mb-3">
                    <label>Tanggal Reservasi</label>

                    <input type="date"
                           name="tanggal_reservasi"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Jam Reservasi</label>

                    <input type="time"
                           name="jam_reservasi"
                           class="form-control"
                           required>
                </div>

            </div>
        </div>


        <!-- STYLIST -->
        <div class="card mb-4">
            <div class="card-body">

                <h3>Pilih Stylist</h3>

                <select name="id_stylist" class="form-select">

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

        <div class="card mb-4">
            <div class="card-body">

                <h3>Pembayaran DP</h3>

                <p>
                    Silakan melakukan pembayaran DP sebesar
                    <strong>50%</strong>
                    melalui QRIS berikut:
                </p>

                <img src="assets/qris.png"
                    class="img-fluid"
                    width="300">

                <hr>

                <p>
                    Atau transfer ke:
                </p>

                <ul>
                    <li>Bank BCA - 1234567890</li>
                    <li>a.n Salon Reservation</li>
                </ul>

            </div>
        </div>

        <!-- BUKTI -->
        <div class="card mb-4">
            <div class="card-body">

                <h3>Upload Bukti Pembayaran</h3>

                <input type="file"
                       name="bukti_pembayaran"
                       class="form-control"
                       required>

            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">

            Simpan Reservasi

        </button>

    </form>

</div>

</body>
</html>