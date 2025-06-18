<?php
include('controller/archive-controller.php');
include('header.php');
include('create-archive.php');
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
        <h1 class="mt-4">Arsip PIDUM</h1>

        <?php if ($role != 'user'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>Welcome <?= htmlspecialchars($username) ?> (<?= htmlspecialchars($role) ?>)</div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                + Create Archive
            </button>
        </div>
        <?php endif; ?>

        <?php
            if ($role != 'user' && isset($_POST['edit'])):
                $id = $_POST['edit'];
                $stmt = $pdo->prepare("SELECT * FROM arsip WHERE id = ?");
                $stmt->execute([$id]);
                $record = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($record):
                    include('edit-archive.php');
                endif;
            endif;
        ?>


        <!-- Search -->
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table me-1"></i> Archive Data</div>
            <div class="card-body">
                <form method="get" id="searchForm" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" id="searchInput" placeholder="Search archive..."
                            value="<?= htmlspecialchars($search) ?>" autocomplete="off" class="form-control" />
                        <noscript><button type="submit" class="btn btn-primary">Search</button></noscript>
                    </div>
                </form>

                <script>
                const input = document.getElementById('searchInput');
                let timer;
                input.addEventListener('input', function() {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        document.getElementById('searchForm').submit();
                    }, 500);
                });
                </script>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-custom text-dark">
                            <tr>
                                <th>ID</th>
                                <th>Pencipta Arsip</th>
                                <th>Nomor Arsip</th>
                                <th>Unit Pengelola</th>
                                <th>Uraian</th>
                                <th>Kode</th>
                                <th>Jumlah</th>
                                <th>Media</th>
                                <th>Kategori</th>
                                <th>Perkembangan</th>
                                <th>Tanggal Diterima</th>
                                <th>Lokasi</th>
                                <th>Kurun Waktu</th>
                                <th>Inaktif</th>
                                <th>Keterangan</th>
                                <?php if ($role != 'user') echo "<th>Actions</th>"; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row): ?>
                            <tr>
                                <?php foreach ($row as $key => $value): ?>
                                <td><?= htmlspecialchars($value) ?></td>
                                <?php endforeach; ?>
                                <?php if ($role != 'user'): ?>
                                <td>
                                    <form method="post" class="d-inline">
                                        <button type="submit" name="edit" value="<?= $row['id'] ?>"
                                            class="btn btn-sm btn-warning">Edit</button>
                                    </form>
                                    <form method="post" class="d-inline"
                                        onsubmit="return confirm('Delete this archive?');">
                                        <button type="submit" name="delete" value="<?= $row['id'] ?>"
                                            class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center flex-wrap">
                        <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a>
                        </li>

                        <?php
                            $range = 2;
                            for ($i = 1; $i <= $totalPages; $i++):
                                if (
                                    $i == 1 || $i == $totalPages ||
                                    ($i >= $currentPage - $range && $i <= $currentPage + $range)
                                ):
                                    if ($i == $currentPage): ?>
                        <li class="page-item active"><span class="page-link"><?= $i ?></span></li>
                        <?php else: ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                        <?php endif;
                                elseif (
                                    $i == $currentPage - $range - 1 ||
                                    $i == $currentPage + $range + 1
                                ): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif;
                            endfor; ?>

                        <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include('footer.php'); ?>