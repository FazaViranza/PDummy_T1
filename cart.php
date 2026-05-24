<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>

    <title>Keranjang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container py-5">

    <h1>Keranjang</h1>

    <?php

    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {

        echo "<div class='alert alert-warning'>Keranjang kosong</div>";

    } else {

        $total = 0;

        foreach($_SESSION['cart'] as $id_layanan => $qty) {

            $sql = "SELECT * FROM layanan WHERE id_layanan = $id_layanan";
            $query = mysqli_query($conn, $sql);

            $data = mysqli_fetch_assoc($query);

            $subtotal = $data['harga'] * $qty;

            $total += $subtotal;

    ?>

            <div class="card mb-3">
                <div class="card-body">

            <h3>
                <?php echo $data['nama_layanan']; ?>
            </h3>

            <p>
                Harga:
                Rp <?php echo number_format($data['harga']); ?>
            </p>

            <p>
                Qty:
                <?php echo $qty; ?>
            </p>

            <p>
                Subtotal:
                Rp <?php echo number_format($subtotal); ?>
            </p>

            <a href="kurang_cart.php?id=<?php echo $id_layanan; ?>"
            class="btn btn-warning">

            -

            </a>

            <a href="tambah_cart.php?id=<?php echo $id_layanan; ?>"
            class="btn btn-success">

            +

            </a>

        </div>
    </div>

    <?php } ?>

        <h3>Total:
            Rp <?php echo number_format($total); ?>
        </h3>

        <br>

        <div class="d-flex gap-2">

        <a href="index.php" class="btn btn-secondary">

            ← Kembali ke Menu

        </a>

        <a href="checkout.php" class="btn btn-success">

            Checkout Sekarang

        </a>

    </div>

    <?php } ?>

</div>

</body>
</html>