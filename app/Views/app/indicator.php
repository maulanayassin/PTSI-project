<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Indikator
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Daftar Indikator</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Indikator</h5>
            <a href="<?= site_url('/app/indicator/form') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No. Indikator</th>
                            <th>Nama Indikator</th>
                            <th>Goal</th>
                            <th>Polaritas</th>
                            <th>Sumber</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_indicator)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data_indicator as $indicator): ?>
                                <tr>
                                    <td><?= esc($indicator['no_indicator']) ?></td>
                                    <td><?= esc($indicator['indicator_name']) ?></td>
                                    <td><?= esc($indicator['goal']) ?></td>
                                    <td><?= esc($indicator['polaritas']) ?></td>
                                    <td><?= esc($indicator['sumber']) ?></td>
                                    <td class="text-center">
                                        <a href="<?= site_url('/app/indicator/edit/' . $indicator['id']) ?>" 
                                           class="btn btn-sm btn-warning">
                                           <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="<?= site_url('/app/indicator/delete/' . $indicator['id']) ?>" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" 
                                              class="d-inline-block">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
