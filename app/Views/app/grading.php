<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
SDG Data Kota
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <!-- Judul -->
    <h2 class="text-center mb-4">Detail SDG Data</h2>

    <!-- Tabel Data -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="m-0 text-center">Data SDG</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <table class="table table-bordered table-striped table-hover table-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Tahun</th>
                                <th>Nama Kota</th>
                                <th>Wilayah</th>
                                <th>Nama Provinsi</th>
                                <th>Tujuan</th>
                                <th>Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sdgData as $data): ?>
                            <tr class="<?= is_null($data['score']) ? 'table-danger' : '' ?>">
                                <td><?= $data['year'] ?></td>
                                <td><?= $data['city_name'] ?></td>
                                <td><?= $data['region'] ?></td>
                                <td><?= $data['province_name'] ?></td>
                                <td><?= $data['goal'] ?></td>
                                <td class="<?= $data['score'] >= 80 ? 'text-success fw-bold' : ($data['score'] >= 50 ? 'text-warning' : 'text-danger') ?>">
                                    <?= is_null($data['score']) ? 'N/A' : $data['score'] ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
