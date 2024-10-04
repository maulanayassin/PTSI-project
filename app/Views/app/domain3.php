<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Domain 1
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Data Domain 3</h2>
<div class="card">
    <div class="card-header">
        <div class="card-actions">
            <a href="<?= site_url('/app/domain3/form') ?>" class="btn btn-pill">Tambah</a>
        </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped">
            <thead>
            <tr>
                <th>No. Indikator</th>
                <th>Nama Indikator</th>
                <th>Keterangan </th>
                <th>Tahun 2019</th>
                <th>Tahun 2020</th>
                <th class="w-8">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($domain3)): ?>
                <tr>
                    <td colspan="7">Tidak ada data</td>
                </tr>
            <?php else: ?>
                <?php foreach ($domain3 as $data_domain3): ?>
                    <tr>
                        <td> <?= esc($data_domain3['no_indicator']) ?></td>
                        <td> <?= esc($data_domain3['indicator_name']) ?></td>
                        <td> <?= esc($data_domain3['information'])?></td> 
                        <td> <?= esc($data_domain3['year_2019']) ?></td>
                        <td> <?= esc($data_domain3['year_2020']) ?></td>
                        <td>
                            <a href="<?= site_url('/app/domain3/edit/' . $data_domain3['id']) ?>"class="btn btn-sm">Edit</a>  
                            <form action="<?= site_url('/app/domain3/delete/' . $data_domain3['id']) ?>" method = "POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline-block"><button type="submit" class="btn btn-sm ">Hapus</form>                                 
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