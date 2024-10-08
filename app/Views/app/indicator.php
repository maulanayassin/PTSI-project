<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Indikator
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Daftar Indikator</h2>
<div class="card">
    <div class="card-header">
        <div class="card-actions">
            <a href="<?= site_url('/app/indicator/form') ?>" class="btn btn-pill">Tambah</a>
        </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped">
            <thead>
            <tr>
                <th>No. Indikator</th>
                <th>Nama Indikator</th>
                <th>goal</th>
                <th>Polaritas</th>
                <th>Tahun</th>
                <th>Sumber</th>
                <th class="w-8">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($data_indicator)): ?>
                <tr>
                    <td colspan="7">Tidak ada data</td>
                </tr>
            <?php else: ?>
                <?php foreach ($data_indicator as $indicator): ?>
                    <tr>
                        <td> <?= esc($indicator['no_indicator']) ?></td>
                        <td> <?= esc($indicator['indicator_name']) ?></td>
                        <td> <?= esc($indicator['goal'])?></td>
                        <td> <?= esc($indicator['polaritas']) ?></td>
                        <td> <?= esc($indicator['tahun']) ?></td>
                        <td> <?= esc($indicator['sumber'])?></td>
                        <td>
                            <a href="<?= site_url('/app/indicator/edit/' . $indicator['id']) ?>"class="btn btn-sm">Edit</a>  
                            <form action="<?= site_url('/app/indicator/delete/' . $indicator['id']) ?>" method = "POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline-block"><button type="submit" class="btn btn-sm ">Hapus</form>                                   
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