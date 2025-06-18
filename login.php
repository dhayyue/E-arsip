<?php
require 'controller/db.php';
session_start();

$loginFailed = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: archive.php");
        exit;
    } else {
        $loginFailed = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login E-Arsip</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" crossorigin="anonymous" />
    <style>
    .glass-card {
        background-color: rgba(138, 135, 135, 0.54);
        /* Lebih gelap dari sebelumnya */
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 30px;
        color: white;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
    }

    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .form-floating label {
        color: #ccc;
    }

    .btn-primary {
        background-color: #1e3a8a;
        border: none;
    }

    .btn-primary:hover {
        background-color: #3b82f6;
    }

    .logo-img {
        max-height: 90px;
    }

    .input-icon {
        position: absolute;
        left: 10px;
        top: 12px;
        color: #bbb;
    }

    .input-group {
        position: relative;
    }

    .form-control::placeholder {
        color: #ccc;
    }

    .card-footer a {
        color: #fff;
    }

    .card-footer a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body
    style="background: url('assets/kejari.jpg') no-repeat center center fixed; background-size: cover; position: relative;">
    <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.65); z-index:0;">
    </div>

    <main class="d-flex align-items-center justify-content-center min-vh-100 position-relative" style="z-index:1;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="glass-card">
                        <div class="text-center mb-4">
                            <img src="assets/logo.png" alt="Logo" class="logo-img">
                            <h4 class="mt-2">Login E-Arsip</h4>
                        </div>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="inputUsername" class="form-label text-white">Username</label>
                                <div class="position-relative">
                                    <i
                                        class="fas fa-user position-absolute top-50 start-0 translate-middle-y ms-3 text-white"></i>
                                    <input type="text" class="form-control ps-5 bg-transparent text-white"
                                        id="inputUsername" name="username" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="inputPassword" class="form-label text-white">Password</label>
                                <div class="position-relative">
                                    <i
                                        class="fas fa-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-white"></i>
                                    <input type="password" class="form-control ps-5 bg-transparent text-white"
                                        id="inputPassword" name="password" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-4 mb-3">
                                <button class="btn btn-primary w-100" type="submit">Login</button>
                            </div>
                        </form>
                        <div class="card-footer text-center">
                            <small>Belum punya akun? <a href="register.php">Daftar sekarang</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Gagal Login -->
    <div class="modal fade" id="loginFailedModal" tabindex="-1" aria-labelledby="loginFailedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Login Gagal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Username atau password salah. Silakan coba lagi.
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <?php if ($loginFailed): ?>
    <script>
    var loginFailedModal = new bootstrap.Modal(document.getElementById('loginFailedModal'));
    loginFailedModal.show();
    </script>
    <?php endif; ?>
</body>

</html>