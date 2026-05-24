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
// AMBIL ID
// ========================

$id = $_GET['id'];


// ========================
// DATA RESERVASI
// ========================

$sqlReservasi = "
SELECT reservasi.*, stylist.nama_stylist
FROM reservasi

LEFT JOIN stylist
ON reservasi.id_stylist = stylist.id_stylist

WHERE id_reservasi = '$id'
";

$queryReservasi = mysqli_query($conn, $sqlReservasi);

$reservasi = mysqli_fetch_assoc($queryReservasi);


// ========================
// DETAIL LAYANAN
// ========================

$sqlDetail = "
SELECT detail_reservasi.*, layanan.nama_layanan

FROM detail_reservasi

JOIN layanan
ON detail_reservasi.id_layanan = layanan.id_layanan

WHERE id_reservasi = '$id'
";

$queryDetail = mysqli_query($conn, $sqlDetail);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Detail Reservasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container py-5">

    <a href="dashboard.php" class="btn btn-secondary mb-4">

        ← Kembali

    </a>

    <div class="card shadow mb-4">

        <div class="card-body">

            <h2 class="mb-4">Detail Reservasi</h2>

            <p>
                <strong>Kode Booking:</strong>
                <?php echo $reservasi['kode_booking']; ?>
            </p>

            <p>
                <strong>Nama Pelanggan:</strong>
                <?php echo $reservasi['nama_pelanggan']; ?>
            </p>

            <p>
                <strong>Email:</strong>
                <?php echo $reservasi['email']; ?>
            </p>

            <p>
                <strong>No HP:</strong>
                <?php echo $reservasi['no_hp']; ?>
            </p>

            <p>
                <strong>Tanggal:</strong>
                <?php echo $reservasi['tanggal_reservasi']; ?>
            </p>

            <p>
                <strong>Jam:</strong>
                <?php echo $reservasi['jam_reservasi']; ?>
            </p>

            <p>
                <strong>Stylist:</strong>
                <?php echo $reservasi['nama_stylist']; ?>
            </p>

            <p>
                <strong>Total:</strong>
                Rp <?php echo number_format($reservasi['total_harga']); ?>
            </p>

            <p>
                <strong>DP:</strong>
                Rp <?php echo number_format($reservasi['dp']); ?>
            </p>

            <p>
                <strong>Status:</strong>

                <span class="badge bg-warning text-dark">

                    <?php echo $reservasi['status_reservasi']; ?>

                </span>
            </p>

        </div>

    </div>


    <!-- DETAIL LAYANAN -->

    <div class="card shadow mb-4">

        <div class="card-body">

            <h3 class="mb-3">Layanan Dipilih</h3>

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Layanan</th>
                        <th>Qty</th>
                        <th>Subtotal</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($detail = mysqli_fetch_assoc($queryDetail)) { ?>

                    <tr>

                        <td>
                            <?php echo $detail['nama_layanan']; ?>
                        </td>

                        <td>
                            <?php echo $detail['qty']; ?>
                        </td>

                        <td>
                            Rp <?php echo number_format($detail['subtotal']); ?>
                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- BUKTI PEMBAYARAN -->

    <div class="card shadow mb-4">

        <div class="card-body">

            <h3 class="mb-3">
                Bukti Pembayaran
            </h3>

            <img src="../uploads/<?php echo $reservasi['bukti_pembayaran']; ?>"
                 class="img-fluid rounded">

        </div>

    </div>


    <!-- VALIDASI -->

    <div class="card shadow">

        <div class="card-body">

            <h3 class="mb-3">
                Validasi Reservasi
            </h3>

            <a href="validasi.php?id=<?php echo $reservasi['id_reservasi']; ?>"
               class="btn btn-success">

               Validasi Reservasi

            </a>

        </div>

    </div>

</div>

</body>
</html>