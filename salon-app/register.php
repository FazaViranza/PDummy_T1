<?php

include 'koneksi.php';

if(isset($_POST['register'])) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    $cek = mysqli_query(
        $conn,
        "SELECT * FROM user WHERE username='$username'"
    );

    if(mysqli_num_rows($cek) > 0) {

        echo "
        <script>
        alert('Username sudah digunakan');
        </script>
        ";

    } else {

        mysqli_query(
            $conn,
            "INSERT INTO user
            (first_name,last_name,username,password)
            VALUES
            (
                '$first_name',
                '$last_name',
                '$username',
                '$password'
            )"
        );

        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Register - Salon Sigma</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
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
                rgba(0,0,0,0.45),
                rgba(0,0,0,0.45)
            ),
            url('assets/hero.jpg');

            background-size:cover;
            background-position:center;

            display:flex;
            align-items:flex-end;

            padding:60px;

            color:white;

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

        .register-box{

            width:100%;
            max-width:450px;

        }

        .register-box h1{

            font-size:56px;
            font-weight:800;

            color:#222;

            margin-bottom:10px;

        }

        .register-box p{

            color:#777;

        }

        .form-control{

            background:white !important;

            color:#222 !important;

            border:1px solid #ddd;

            padding:12px;

            border-radius:10px;

        }

        .form-control:focus{

            border-color:#c9a26b;

            box-shadow:none;

        }

        .btn-register{

            background:#111;

            color:white;

            border:none;

            padding:12px;

            border-radius:10px;

            font-weight:600;

        }

        .btn-register:hover{

            background:#222;

            color:white;

        }

        .brand-title{

            font-size:60px;

            font-weight:800;

        }

        .brand-desc{

            font-size:20px;

            max-width:500px;

        }

        @media(max-width:992px){

            .auth-left{
                display:none;
            }

            .auth-right{
                width:100%;
            }

        }

    </style>

</head>

<body>

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

        <div class="register-box">

            <h1>

                Join Us!

            </h1>

            <p class="mb-4">

                Buat akun untuk mulai reservasi salon favorit Anda.

            </p>

            <form method="POST">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            First Name

                        </label>

                        <input
                            type="text"
                            name="first_name"
                            class="form-control"
                            placeholder="e.g.Faza"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Last Name

                        </label>

                        <input
                            type="text"
                            name="last_name"
                            class="form-control"
                            placeholder="e.g.Viranza"
                            required>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Username

                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        placeholder="Create your username"
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
                        placeholder="Create your password"
                        required>

                </div>

                <button
                    type="submit"
                    name="register"
                    class="btn btn-register w-100">

                    Create Account

                </button>

            </form>

            <hr>

            <p class="text-center">

                Sudah punya akun?

                <a href="login.php">

                    Login

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