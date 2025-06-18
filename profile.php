<?php
session_start();
require 'controller/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Ambil data user
$stmt = $pdo->prepare("SELECT username, email FROM user WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE user SET username = ?, email = ?, password = ? WHERE id = ?");
        $stmt->execute([$newUsername, $newEmail, $hashedPassword, $userId]);
    } else {
        $stmt = $pdo->prepare("UPDATE user SET username = ?, email = ? WHERE id = ?");
        $stmt->execute([$newUsername, $newEmail, $userId]);
    }

    $_SESSION['username'] = $newUsername;

    header("Location: profile.php?updated=true");
    exit;
}
?>

<?php include('header.php'); ?>

<head>
</head>
<main>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <img src="assets/user.png" class="rounded-circle shadow border border-3 border-light"
                                style="width: 110px; height: 110px; object-fit: cover;">
                            <h4 class="mt-3 fw-bold text-dark">Profil Saya</h4>
                        </div>

                        <?php if (isset($_GET['updated'])): ?>
                        <div class="alert alert-success text-center rounded-pill py-2">
                            ✅ Profil berhasil diperbarui.
                        </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Username</label>
                                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>"
                                    class="form-control rounded-pill px-4 py-2" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                                    class="form-control rounded-pill px-4 py-2" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password Baru <span
                                        class="text-muted">(opsional)</span></label>
                                <input type="password" name="password" class="form-control rounded-pill px-4 py-2"
                                    placeholder="Biarkan kosong jika tidak ingin mengganti">
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success rounded-pill fw-semibold px-4 py-2">
                                    Simpan
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<?php include('footer.php');
?>