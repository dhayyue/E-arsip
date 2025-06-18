<?php
include('controller/archive-controller.php');
include('header.php');
include('create-archive.php');
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Arsip PIDSUS</h1>

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