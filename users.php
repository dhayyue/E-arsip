<?php
include('controller/users-controller.php');
include('header.php');
include('create-user.php'); 
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
        <h1 class="mt-4">Manage Users</h1>

        <?php if ($role != 'user'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>Welcome <?= htmlspecialchars($username) ?> (<?= htmlspecialchars($role) ?>)</div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                + Add User
            </button>
        </div>
        <?php endif; ?>

        <!-- Edit user modal trigger handled by buttons in table -->

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table me-1"></i> User Data</div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-custom text-dark">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <?php if ($role != 'user'): ?>
                            <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <?php if ($role != 'user'): ?>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="openEditForm(
                                            <?= $user['id'] ?>, 
                                            '<?= htmlspecialchars($user['username'], ENT_QUOTES) ?>', 
                                            '<?= htmlspecialchars($user['role'], ENT_QUOTES) ?>'
                                        )" data-bs-toggle="modal" data-bs-target="#editUserModal">
                                    Edit
                                </button>

                                <form method="post" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="delete" class="btn btn-sm btn-danger">Delete</button>
                                </form>

                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include('footer.php'); ?>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username:</label>
                        <input type="text" name="username" id="edit_username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Role:</label>
                        <select name="role" id="edit_role" class="form-select" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="superadmin">Superadmin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditForm(id, username, role) {
    document.getElementById('edit_user_id').value = id;
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_role').value = role;
}
</script>