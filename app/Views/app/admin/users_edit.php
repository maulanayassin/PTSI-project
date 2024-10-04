<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Edit Pengguna</h2>
<form action="<?= site_url('/admin/users/update/' . $user['id']) ?>" method="post">
    <?= csrf_field() ?> 
    <div class="card">
        <!-- <div class="card-header">
            <h3>Edit Pengguna</h3>
        </div> -->
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" value="<?= esc($user['username']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="<?= esc($user['email']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                </select>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-pill btn-primary">Simpan</button>
        </div>
    </div>
</form>
<?= $this->endSection() ?>
