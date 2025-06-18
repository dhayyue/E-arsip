<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];
$username = $_SESSION['username'];

// Handle create
if ($role != 'user' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $stmt = $pdo->prepare("INSERT INTO arsip (
        Pencipta_Arsip, Nomor_Arsip, Unit_Pengelola, Uraian_Informasi,
        Kode_Klasifikasi, Jumlah, Media, Kategori_Arsip,
        Tingkat_Perkembangan_Arsip, Tanggal_Diterima, Lokasi_Simpan,
        Kurun_Waktu, inaktif, Keterangan
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $_POST['Pencipta_Arsip'], $_POST['Nomor_Arsip'], $_POST['Unit_Pengelola'], $_POST['Uraian_Informasi'],
        $_POST['Kode_Klasifikasi'], $_POST['Jumlah'], $_POST['Media'], $_POST['Kategori_Arsip'],
        $_POST['Tingkat_Perkembangan_Arsip'], $_POST['Tanggal_Diterima'], $_POST['Lokasi_Simpan'],
        $_POST['Kurun_Waktu'], $_POST['inaktif'], $_POST['Keterangan']
    ]);
}

// Get page number early for redirect reuse
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

// Handle delete
if ($role != 'user' && isset($_POST['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM arsip WHERE id = ?");
    $stmt->execute([$_POST['delete']]);
    header("Location: archive.php?page=$page");
    exit;
}

// Handle update
if ($role != 'user' && isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE arsip SET 
        Pencipta_Arsip=?, Nomor_Arsip=?, Unit_Pengelola=?, Uraian_Informasi=?,
        Kode_Klasifikasi=?, Jumlah=?, Media=?, Kategori_Arsip=?,
        Tingkat_Perkembangan_Arsip=?, Tanggal_Diterima=?, Lokasi_Simpan=?,
        Kurun_Waktu=?, inaktif=?, Keterangan=? 
        WHERE id = ?");

    $stmt->execute([
        $_POST['Pencipta_Arsip'], $_POST['Nomor_Arsip'], $_POST['Unit_Pengelola'], $_POST['Uraian_Informasi'],
        $_POST['Kode_Klasifikasi'], $_POST['Jumlah'], $_POST['Media'], $_POST['Kategori_Arsip'],
        $_POST['Tingkat_Perkembangan_Arsip'], $_POST['Tanggal_Diterima'], $_POST['Lokasi_Simpan'],
        $_POST['Kurun_Waktu'], $_POST['inaktif'], $_POST['Keterangan'], $_POST['id']
    ]);

    header("Location: archive.php");
    exit;
}

// Fetch data
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$recordsPerPage = 15;
$offset = ($page - 1) * $recordsPerPage;
$params = [];

if ($search !== '') {
    $stmt = $pdo->prepare("
        SELECT * FROM arsip WHERE 
        Pencipta_Arsip LIKE ? OR Nomor_Arsip LIKE ? OR Unit_Pengelola LIKE ? OR Uraian_Informasi LIKE ? OR 
        Kode_Klasifikasi LIKE ? OR Jumlah LIKE ? OR Media LIKE ? OR Kategori_Arsip LIKE ? OR 
        Tingkat_Perkembangan_Arsip LIKE ? OR Tanggal_Diterima LIKE ? OR Lokasi_Simpan LIKE ? OR 
        Kurun_Waktu LIKE ? OR inaktif LIKE ? OR Keterangan LIKE ?
        LIMIT $recordsPerPage OFFSET $offset
    ");
    $params = array_fill(0, 14, "%$search%");
    $stmt->execute($params);

    $countStmt = $pdo->prepare("
        SELECT COUNT(*) FROM arsip WHERE 
        Pencipta_Arsip LIKE ? OR Nomor_Arsip LIKE ? OR Unit_Pengelola LIKE ? OR Uraian_Informasi LIKE ? OR 
        Kode_Klasifikasi LIKE ? OR Jumlah LIKE ? OR Media LIKE ? OR Kategori_Arsip LIKE ? OR 
        Tingkat_Perkembangan_Arsip LIKE ? OR Tanggal_Diterima LIKE ? OR Lokasi_Simpan LIKE ? OR 
        Kurun_Waktu LIKE ? OR inaktif LIKE ? OR Keterangan LIKE ?
    ");
    $countStmt->execute($params);
    $totalRows = $countStmt->fetchColumn();
} else {
    $stmt = $pdo->prepare("SELECT * FROM arsip LIMIT $recordsPerPage OFFSET $offset");
    $stmt->execute();
    $totalRows = $pdo->query("SELECT COUNT(*) FROM arsip")->fetchColumn();
}

$totalPages = ceil($totalRows / $recordsPerPage);

$currentPage = max(1, min($page, $totalPages));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
