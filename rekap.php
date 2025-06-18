<?php
include('controller/archive-controller.php');
include('header.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
  header("Location: archive.php");
  exit;
}

require 'controller/db.php';
$stmt = $pdo->query("
  SELECT LEFT(Tanggal_Diterima, 4) AS tahun, COUNT(*) AS total
  FROM arsip
  GROUP BY tahun
  ORDER BY tahun DESC
");
$data = $stmt->fetchAll();


?>

<head>
    <style>
    .table-custom {
        background-color: #e9efff;
        border-bottom: 2px solid #ced4da;
    }

    table {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
        transition: 0.2s ease;
    }

    .btn-sm {
        font-size: 0.75rem;
        padding: 4px 8px;
    }
    </style>
</head>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Rekap Jumlah Arsip per Tahun</h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-calendar-alt me-1"></i>
                Tabel Rekapan Arsip Tahunan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-custom text-dark">
                            <tr>
                                <th>Tahun</th>
                                <th>Jumlah Arsip</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['tahun']) ?></td>
                                <td><?= htmlspecialchars($row['total']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('footer.php'); ?>