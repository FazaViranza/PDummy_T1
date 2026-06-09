<?php

session_start();
include '../koneksi.php';

if(isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "
    SELECT *
    FROM admin
    WHERE username = '$username'
    AND password = '$password'
    ";

    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) > 0) {

        $_SESSION['admin'] = $username;

        header("Location: dashboard.php");
        exit;

    } else {

        $error = "Username atau Password salah";

    }
}

?>

<!DOCTYPE html>

<html>

<head>


<title>Admin Login - Salon Sigma</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet">

<style>

    body{

        margin:0;
        padding:0;

        overflow:hidden;

    }

    .auth-container{

        display:flex;

        width:100vw;
        height:100vh;

    }

    .auth-left{

        width:60%;

        background:
        linear-gradient(
            rgba(0,0,0,0.55),
            rgba(0,0,0,0.55)
        ),
        url('../assets/hero.jpg');

        background-size:cover;
        background-position:center;

        color:white;

        display:flex;
        align-items:flex-end;

        padding:60px;

    }

    .auth-right{

        width:40%;

        background:white;

        display:flex;
        justify-content:center;
        align-items:center;

        padding:50px;

        box-shadow:
        -15px 0 40px rgba(0,0,0,0.12);

    }

    .login-box{

        width:100%;
        max-width:420px;

    }

    .login-box h1{

        font-size:56px;

        font-weight:800;

        color:#222;

        margin-bottom:10px;

    }

    .login-box p{

        color:#777;

    }

    .brand-title{

        font-size:64px;

        font-weight:800;

    }

    .brand-desc{

        font-size:20px;

        max-width:550px;

        color:rgba(255,255,255,0.9);

    }

    .form-control{

        border:1px solid #ddd;

        border-radius:12px;

        padding:12px;

    }

    .form-control:focus{

        border-color:#c89b6d;

        box-shadow:none;

    }

    .btn-login{

        background:#111;

        color:white;

        border:none;

        border-radius:12px;

        padding:12px;

        font-weight:600;

    }

    .btn-login:hover{

        background:#222;

        color:white;

    }

    .admin-badge{

        display:inline-block;

        background:#c89b6d;

        color:white;

        padding:8px 18px;

        border-radius:30px;

        font-size:13px;

        font-weight:600;

        margin-bottom:20px;

    }

</style>


</head>

<body>

<div class="container-fluid p-0">


<div class="auth-container">

    <!-- KIRI -->

    <div class="auth-left">

        <div>

            <div class="admin-badge">

                ADMIN PANEL

            </div>

            <h1 class="brand-title">

                Salon Sigma

            </h1>

            <p class="brand-desc">

                Kelola reservasi pelanggan, validasi pembayaran,
                dan manajemen layanan salon melalui dashboard admin.

            </p>

        </div>

    </div>


    <!-- KANAN -->

    <div class="auth-right">

        <div class="login-box">

            <h1>

                Admin Login

            </h1>

            <p class="mb-4">

                Masuk ke dashboard administrasi Salon Sigma.

            </p>

            <?php if(isset($error)) { ?>

                <div class="alert alert-danger">

                    <?php echo $error; ?>

                </div>

            <?php } ?>

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">

                        Username

                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        required>

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required>

                </div>

                <button
                    type="submit"
                    name="login"
                    class="btn btn-login w-100">

                    Login Admin

                </button>

            </form>

            <hr>

            <p class="text-center mb-0">

                <a href="../index.php">

                    ← Kembali ke Website

                </a>

            </p>

        </div>

    </div>

</div>


</div>

</body>
</html>
