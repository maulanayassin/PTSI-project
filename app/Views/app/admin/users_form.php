<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Tambah Pengguna</h2>
<form action="<?= site_url('/admin/users/submit') ?>" method="post">
<?= csrf_field() ?> 
<div class="card">
    <div class="card-header">
        <!-- <div class="card-actions">
            <button type="submit" class="btn btn-pill">Simpan</button>
        </div> -->
        <div class="card-body">
            <div class="row">
                <!-- <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="example-text-input" placeholder="Input placeholder">
                </div> -->
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required placeholder="Masukkan Username">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <!-- <option value="">Pilih Role</option> -->
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <!-- <div class="form-group col-md-6">
                    <label class="form-label">Password</label>
                    <input type="text" name="password" id="password" class="form-control">
                </div> -->
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-pill btn-primary">Simpan</button>
    </div>
</div>
</form>


<?= $this->endSection() ?>