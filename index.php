<?php
session_start();

include 'koneksi.php';

if(isset($_GET['search'])) {

    $search = $_GET['search'];

    $sql = "
    SELECT * FROM layanan
    WHERE nama_layanan LIKE '%$search%'
    ";

} else {

    $sql = "SELECT * FROM layanan";

}

$query = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Salon Reservation</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container">

            <a class="navbar-brand" href="index.php">
                Salon Reservation
            </a>

            <a href="cart.php" class="btn btn-outline-light">

                Keranjang

                <?php
                $jumlah_cart = isset($_SESSION['cart'])
                    ? array_sum($_SESSION['cart'])
                    : 0;
                ?>

                (<?php echo $jumlah_cart; ?>)

            </a>

        </div>

    </nav>
    <div class="container py-5">

        <h1 class="text-center mb-5">
            Daftar Layanan Salon
        </h1>

    <form method="GET" class="mb-4">

    <div class="input-group">

                <input type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari layanan...">

                <button class="btn btn-dark">

                    Search

                </button>

            </div>

        </form>

        <div class="row">

            <?php while($data = mysqli_fetch_assoc($query)) { ?>

                <div class="col-md-6 col-lg-4 mb-4">

                    <div class="card shadow h-100">

                        <div class="card-body">

                            <h3 class="card-title">
                                <?php echo $data['nama_layanan']; ?>
                            </h3>

                            <h5 class="text-primary">
                                Rp <?php echo number_format($data['harga']); ?>
                            </h5>

                            <p>
                                Durasi:
                                <?php echo $data['durasi_menit']; ?> menit
                            </p>

                            <p>
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

</body>
</html>