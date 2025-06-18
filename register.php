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
        // Optional: log the error for debugging
        // error_log($e->getMessage());
        $registrationError = true;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Register - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body style="background: url('assets/kejari.jpg') no-repeat center center fixed; background-size: cover;">
    <div style="position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index:-1;">
    </div>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main class="d-flex align-items-center justify-content-center min-vh-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg">
                                <div class="card-header text-center">
                                    <img src="assets/logo.png" alt="Logo" class="img-fluid my-3"
                                        style="max-height: 100px;">
                                    <h3 class="font-weight-light my-2">Register</h3>
                                </div>

                                <div class="card-body">
                                    <?php if ($registrationSuccess): ?>
                                    <div class="alert alert-success text-center">
                                        Registered successfully. <a href="login.php">Login here</a>
                                    </div>
                                    <?php else: ?>
                                    <form method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" name="email"
                                                placeholder="Enter your email" required />
                                            <label for="inputEmail">Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputUsername" type="text" name="username"
                                                placeholder="Enter a username" required />
                                            <label for="inputUsername">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password"
                                                name="password" placeholder="Enter a password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit">Register</button>
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">Already have an account? Login here!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal for registration error -->
    <div class="modal fade" id="registerErrorModal" tabindex="-1" aria-labelledby="registerErrorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="registerErrorModalLabel">Registration Error</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Error: Username might already exist. Please choose another one.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>

    <?php if ($registrationError): ?>
    <script>
    var errorModal = new bootstrap.Modal(document.getElementById('registerErrorModal'));
    errorModal.show();
    </script>
    <?php endif; ?>
</body>

</html>