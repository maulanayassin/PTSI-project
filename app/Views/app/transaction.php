<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Provinsi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Data provinsi</h2>
<div class="card">
    <div class="card-header">
        <div class="card-actions">
            <div class="dropdown d-inline-block">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Pilih Domain
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?= site_url('app/domain1') ?>">Domain 1</a>
                    <a class="dropdown-item" href="<?= site_url('app/domain2') ?>">Domain 2</a>    
                    <a class="dropdown-item" href="<?= site_url('app/domain3') ?>">Domain 3</a>
                </div>
            </div>
            <a href="<?= site_url('/app/transaction/form') ?>" class="btn btn-pill">Tambah</a>
        </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped">
            <thead>
            <tr>
                <th>Nama Kota</th>
                <th>No. Indikator</th>
                <th>Goal </th>
                <th>Tahun 2019</th>
                <th>Tahun 2020</th>
                <th class="w-8">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($transaksi)): ?>
                <tr>
                    <td colspan="7">Tidak ada data</td>
                </tr>
            <?php else: ?>
                <?php foreach ($transaksi as $transaction): ?>
                    <tr>
                        <td> <?= esc($transaction['city_name']) ?></td>
                        <td> <?= esc($transaction['indicator_id']) ?></td>
                        <td> <?= esc($transaction['goal'])?></td> 
                        <td> <?= esc($transaction['year_2019']) ?></td>
                        <td> <?= esc($transaction['year_2020']) ?></td>
                        <td>
                            <a href="<?= site_url('/app/Transaction/edit/' . $transaction['id']) ?>"class="btn btn-sm">Edit</a>  
                            <form action="<?= site_url('/app/Transaction/delete/' . $transaction['id']) ?>" method = "POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline-block"><button type="submit" class="btn btn-sm ">Hapus</form>                                 
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