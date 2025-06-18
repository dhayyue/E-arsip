<?php if (isset($record)): ?>
<div class="modal fade show" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-modal="true" role="dialog" style="display: block;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Archive Entry (ID: <?= htmlspecialchars($record['id']) ?>)</h5>
                    <button type="button" class="btn-close" aria-label="Close" id="editModalCloseBtn"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($record['id']) ?>">
                    <div class="row g-3">
                        <?php foreach ($record as $key => $value):
                            if ($key === 'id') continue;
                            $type = 'text'; ?>
                            <div class="col-md-6">
                                <input name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>" placeholder="<?= str_replace('_', ' ', htmlspecialchars($key)) ?>" type="<?= $type ?>" class="form-control" required>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" id="editModalCancelBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Backdrop overlay for modal -->
<div class="modal-backdrop fade show"></div>

<script>
    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const backdrop = document.querySelector('.modal-backdrop');
        if (modal) modal.style.display = 'none';
        if (backdrop) backdrop.remove();
    }

    // Close modal on clicking close or cancel buttons
    document.getElementById('editModalCloseBtn').addEventListener('click', closeEditModal);
    document.getElementById('editModalCancelBtn').addEventListener('click', closeEditModal);

    // Close modal on pressing Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeEditModal();
        }
    });
</script>
<?php endif; ?>
