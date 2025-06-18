<?php
require 'controller/db.php';

$registrationSuccess = false;
$registrationError = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user';

    try {
        $stmt = $pdo->prepare("INSERT INTO user (username, password, email, role) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$username, $password, $email, $role])) {
            $registrationSuccess = true;
        }
    } catch (PDOException $e) {
        $registrationError = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register E-Arsip</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" crossorigin="anonymous" />
    <style>
    .glass-card {
        background-color: rgba(138, 135, 135, 0.54);
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

<body style="background: url('assets/kejari.jpg') no-repeat center center fixed; background-size: cover;">
    <div style="position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.65); z-index:-1;">
    </div>

    <main class="d-flex align-items-center justify-content-center min-vh-100 position-relative" style="z-index:1;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="glass-card">
                        <div class="text-center mb-4">
                            <img src="assets/logo.png" alt="Logo" class="logo-img">
                            <h4 class="mt-2">Register E-Arsip</h4>
                        </div>

                        <?php if ($registrationSuccess): ?>
                        <div class="alert alert-success text-center">
                            Berhasil mendaftar. <a href="login.php">Login di sini</a>
                        </div>
                        <?php else: ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="inputEmail" class="form-label text-white">Email</label>
                                <input type="email" class="form-control bg-transparent text-white" id="inputEmail"
                                    name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="inputUsername" class="form-label text-white">Username</label>
                                <input type="text" class="form-control bg-transparent text-white" id="inputUsername"
                                    name="username" required>
                            </div>

                            <div class="mb-3">
                                <label for="inputPassword" class="form-label text-white">Password</label>
                                <input type="password" class="form-control bg-transparent text-white" id="inputPassword"
                                    name="password" required>
                            </div>

                            <div class="d-flex justify-content-center mt-4 mb-3">
                                <button class="btn btn-primary w-100" type="submit">Register</button>
                            </div>
                        </form>
                        <?php endif; ?>

                        <div class="card-footer text-center">
                            <small>Sudah punya akun? <a href="login.php">Login sekarang</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Gagal Register -->
    <div class="modal fade" id="registerErrorModal" tabindex="-1" aria-labelledby="registerErrorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Registrasi Gagal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Username mungkin sudah digunakan. Silakan coba yang lain.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php if ($registrationError): ?>
    <script>
    var registerErrorModal = new bootstrap.Modal(document.getElementById('registerErrorModal'));
    registerErrorModal.show();
    </script>
    <?php endif; ?>
</body>

</html>