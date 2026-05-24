<?php
session_start();
include '../koneksi.php';

if(isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "
    SELECT * FROM admin
    WHERE username = '$username'
    AND password = '$password'
    ";

    $query = mysqli_query($conn, $sql);

    $cek = mysqli_num_rows($query);

    if($cek > 0) {

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

    <title>Login Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="text-center mb-4">
                        Login Admin
                    </h2>

                    <?php if(isset($error)) { ?>

                        <div class="alert alert-danger">

                            <?php echo $error; ?>

                        </div>

                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label>Username</label>

                            <input type="text"
                                   name="username"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label>Password</label>

                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>

                        </div>

                        <button type="submit"
                                name="login"
                                class="btn btn-dark w-100">

                            Login

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>