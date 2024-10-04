<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Profile
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Profile</h2>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <form action="<?= site_url('/app/profile/update/') ?>" method="post">
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
                            <label class="form-label">Password</label>
                            <input type="password" name="password" value="<?= esc($user['password']) ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-pill btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
