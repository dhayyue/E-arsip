<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="">
        <div class="modal-header">
          <h5 class="modal-title" id="createUserModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="new_username" class="form-label">Username</label>
            <input type="text" name="username" id="new_username" class="form-control" required autocomplete="off" />
          </div>
          <div class="mb-3">
            <label for="new_password" class="form-label">Password</label>
            <input type="password" name="password" id="new_password" class="form-control" required autocomplete="new-password" />
          </div>
          <div class="mb-3">
            <label for="new_role" class="form-label">Role</label>
            <select name="role" id="new_role" class="form-select" required>
              <option value="user" selected>User</option>
              <option value="admin">Admin</option>
              <option value="superadmin">Superadmin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_user" class="btn btn-primary">Create User</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
