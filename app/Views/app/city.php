<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Kabupaten / Kota
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Daftar Kabupaten / Kota</h2>
<div class="card">
    <div class="card-header">
        <div class="card-actions">
            <a href="<?= site_url('/app/city/form') ?>" class="btn btn-pill">Tambah</a>
        </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kab / Kota</th>
                <th>Provinsi</th>
                <th>Kode BPS</th>
                <th>Kode Kemendagri</th>
                <th class="w-8">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($data_city)): ?>
                <tr>
                    <td colspan="3">Tidak ada data</td>
                </tr>
            <?php else: ?>
                <?php foreach ($data_city as $city): ?>
                    <tr>
                        <td><?= $city['id'] ?></td>
                        <td> <?= esc($city['city_name']) ?></td>
                        <td> <?= esc($city['province_name']) ?></td>
                        <td> <?= esc($city['bps_code']) ?></td>
                        <td> <?= esc($city['kemendagri_code']) ?></td>
                        <td>
                            <a href="<?= site_url('/app/city/edit/' . $city['id']) ?>"class="btn btn-sm">Edit</a>  
                            <form action="<?= site_url('/app/city/delete/' . $city['id']) ?>" method = "POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline-block"><button type="submit" class="btn btn-sm ">Hapus</form>                                    
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