<?php
include 'session.php';
include 'db.php';

$role = $_SESSION['role'];
$username = $_SESSION['username'];

require_login();
require_role('superadmin');

$stmt = $pdo->query("SELECT id, username, role FROM user");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_user'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            echo "<script>alert('Username \"$username\" is already taken. Please choose another.'); window.location.href='users.php';</script>";
            exit;
        } else {
            $stmt = $pdo->prepare("INSERT INTO user (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$username, $password, $role]);

            header("Location: users.php");
            exit;
        }
    }

    if (isset($_POST['edit'])) {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $role = $_POST['role'];

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE username = ? AND id != ?");
        $stmt->execute([$username, $user_id]);
        if ($stmt->fetchColumn() > 0) {
            echo "<script>alert('Username \"$username\" is already taken by another user.'); window.location.href='users.php';</script>";
            exit;
        } else {
            $stmt = $pdo->prepare("UPDATE user SET username = ?, role = ? WHERE id = ?");
            $stmt->execute([$username, $role, $user_id]);

            header("Location: users.php");
            exit;
        }
    }

    if (isset($_POST['delete'])) {
        $user_id = $_POST['user_id'];

        if ($user_id == 1) {
            echo "<script>alert('You cannot delete the superadmin account.'); window.location.href='users.php';</script>";
            exit;
        } else {
            $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
            $stmt->execute([$user_id]);

            header("Location: users.php");
            exit;
        }
    }
}
?>
