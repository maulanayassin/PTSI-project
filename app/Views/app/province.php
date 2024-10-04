<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Provinsi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Daftar Provinsi</h2>
<div class="card">
    <div class="card-header">
        <div class="card-actions">
            <a href="<?= site_url('/app/province/form') ?>" class="btn btn-pill">Tambah</a>
        </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nama Provinsi</th>
                <th>Kode BPS</th>
                <th>Kode Kemendagri</th>
                <th class="w-8">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($province)): ?>
                <tr>
                    <td colspan="3">Tidak ada data</td>
                </tr>
            <?php else: ?>
                <?php foreach ($province as $prov): ?>
                    <tr>
                        <td><?= $prov['id'] ?></td>
                        <td> <?= esc($prov['province_name']) ?></td>
                        <td> <?= esc($prov['bps_code']) ?></td>
                        <td> <?= esc($prov['kemendagri_code']) ?></td>
                        <td>
                            <a href="<?= site_url('/app/province/edit/' . $prov['id']) ?>"class="btn btn-sm">Edit</a>  
                            <form action="<?= site_url('/app/province/delete/' . $prov['id']) ?>" method = "POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline-block"><button type="submit" class="btn btn-sm ">Hapus</form>                                     
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