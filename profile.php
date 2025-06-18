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
<main>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body p-4">

                        <h3 class="text-center mb-4 fw-bold text-primary">Profil Saya</h3>

                        <?php if (isset($_GET['updated'])): ?>
                        <div class="alert alert-success text-center mb-4 rounded-pill">
                            ✅ Profil berhasil diperbarui.
                        </div>
                        <?php endif; ?>

                        <!-- Foto Profil -->
                        <div class="text-center mb-4">
                            <img src="assets/user.png" alt="Foto Profil" class="rounded-circle border border-2"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        </div>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Username</label>
                                <input name="username" type="text" class="form-control rounded-pill px-4 py-2"
                                    value="<?= htmlspecialchars($user['username']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input name="email" type="email" class="form-control rounded-pill px-4 py-2"
                                    value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password Baru (opsional)</label>
                                <input name="password" type="password" class="form-control rounded-pill px-4 py-2"
                                    placeholder="Biarkan kosong jika tidak ingin mengganti">
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('footer.php'); ?>