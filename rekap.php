<?php
include('controller/archive-controller.php');
include('header.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: archive.php");
    exit;
}

require 'controller/db.php';

$stmt = $pdo->query("
  SELECT tahun, COUNT(*) AS total FROM (
    SELECT 
      SUBSTRING_INDEX(Tanggal_Diterima, ' ', -1) AS tahun
    FROM arsip
    WHERE SUBSTRING_INDEX(Tanggal_Diterima, ' ', -1) REGEXP '^[0-9]{4}$'

    UNION ALL

    SELECT 
      REGEXP_SUBSTR(Kategori_Arsip, '[0-9]{4}') AS tahun
    FROM arsip
    WHERE Kategori_Arsip REGEXP '[0-9]{4}'
  ) AS gabungan_tahun
  WHERE tahun IS NOT NULL
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
        <h1 class="mt-4">Rekap Arsip PIDUM</h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-calendar-alt me-1"></i>
                Tabel Rekapan Arsip Tahunan
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <canvas id="rekapChart" height="100"></canvas>
                </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('rekapChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($data, 'tahun')) ?>,
        datasets: [{
            label: 'Jumlah Arsip',
            data: <?= json_encode(array_column($data, 'total')) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Total: ' + context.parsed.y;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Arsip'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Tahun'
                }
            }
        }
    }
});
</script>


<?php include('footer.php'); ?>