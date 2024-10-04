<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Daftar Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Daftar Pengguna</h2> 
<div class="card">
    <div class="card-header">
        <div class="card-actions">
            <a href="<?= site_url('/admin/users/create') ?>" class="btn btn-pill">Tambah Pengguna</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="w-8" >Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="5">Tidak ada data pengguna</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= esc($user['id']) ?></td>
                                <td><?= esc($user['username']) ?></td>
                                <td><?= esc($user['email']) ?></td>
                                <td><?= esc($user['role']) ?></td>
                                <td>
                                    <a href="<?= site_url('/admin/users/edit/' . $user['id']) ?>"class="btn btn-sm">Edit</a>  
                                    <form action="<?= site_url('/admin/users/delete/' . $user['id']) ?>" method = "POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline-block"><button type="submit" class="btn btn-sm ">Hapus</form>                                    
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>  
        </div>
    </div>
</div>

<?= $this->endSection() ?>
