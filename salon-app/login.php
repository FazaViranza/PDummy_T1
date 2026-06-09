<?php

session_start();
include 'koneksi.php';

if(isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM user WHERE username='$username'"
    );

    if(mysqli_num_rows($query) > 0) {

        $user = mysqli_fetch_assoc($query);

        if(password_verify($password, $user['password'])) {

            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['first_name'] = $user['first_name'];

            header("Location: index.php");
            exit;

        } else {

            echo "
            <script>
            alert('Password salah');
            </script>
            ";
        }

    } else {

        echo "
        <script>
        alert('Username tidak ditemukan');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Login - Salon Sigma</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{

            margin:0;
            padding:0;

            width:100%;
            height:100%;

            overflow:hidden;

        }

        .auth-container{

            display:flex;

            width:100vw;
            height:100vh;

        }

        .auth-left{

            position:relative;

            width:60%;

            background:
            linear-gradient(
                rgba(0,0,0,0.45),
                rgba(0,0,0,0.45)
            ),
            url('assets/hero.jpg');

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

            box-shadow:-15px 0 40px rgba(0,0,0,0.12);
        }

        .login-box{

            width:100%;
            max-width:420px;
        }

        .login-box h1{

            font-size:56px;
            font-weight:800;
            margin-bottom:10px;

            color:#222;
        }

        .login-box p{

            color:#777;
        }

        .form-control{

            background:white !important;
            color:#222 !important;

            border:1px solid #ddd;

            padding:12px;
        }

        .form-control::placeholder{

            color:#999;
        }

        .btn-login{

            background:#111;
            color:white;

            border:none;

            padding:12px;

            border-radius:10px;
        }

        .btn-login:hover{

            background:#222;
        }

        .brand-title{

            font-size:60px;
            font-weight:bold;
        }

        .brand-desc{

            font-size:20px;

            max-width:500px;
        }

    </style>

</head>

<body>

<div class="container-fluid p-0">

    <div class="auth-container">

    <!-- KIRI -->

        <div class="auth-left">

            <div>

                <h1 class="brand-title">

                    Salon Sigma

                </h1>

                <p class="brand-desc">

                    Premium Hair & Beauty Experience.
                    Reservasi salon online dengan stylist profesional.

                </p>

            </div>

        </div>


        <!-- KANAN -->

        <div class="auth-right">

            <div class="login-box">

                <h1>

                    Welcome Back!

                </h1>

                <p class="mb-4">

                    Login untuk melanjutkan reservasi Anda.

                </p>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">

                            Username

                        </label>

                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="Enter your username"
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
                            placeholder="Enter your password"
                            required>

                    </div>

                    <button
                        type="submit"
                        name="login"
                        class="btn btn-login w-100">

                        Login

                    </button>

                </form>

                <hr>

                <p class="text-center">

                    Belum punya akun?

                    <a href="register.php">

                        Register

                    </a>

                </p>

                <p class="text-center">

                    <a href="index.php">

                        ← Kembali ke Home

                    </a>

                </p>

            </div>

        </div>

    </div>

</body>
</html>