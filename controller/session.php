<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function require_role($role) {
    if ($_SESSION['role'] !== $role) {
        echo "Access denied!";
        exit;
    }
}

function require_roles($roles) {
    if (!in_array($_SESSION['role'], $roles)) {
        echo "Access denied!";
        exit;
    }
}
?>
