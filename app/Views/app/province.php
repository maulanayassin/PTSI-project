<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Provinsi
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Daftar Provinsi</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Provinsi</h5>
            <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= site_url('/app/province/form') ?>" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nama Provinsi</th>
                            <th>Kode BPS</th>
                            <th>Kode Kemendagri</th>
                            <?php if (session()->get('role') === 'admin'): ?>
                                <th class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($province)): ?>
                            <tr>
                                <td colspan="<?= (session()->get('role') === 'admin') ? '5' : '4' ?>" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($province as $prov): ?>
                                <tr>
                                    <td class="text-center"><?= esc($prov['id']) ?></td>
                                    <td><?= esc($prov['province_name']) ?></td>
                                    <td class="text-center"><?= esc($prov['bps_code']) ?></td>
                                    <td class="text-center"><?= esc($prov['kemendagri_code']) ?></td>
                                    <?php if (session()->get('role') === 'admin'): ?>
                                        <td class="text-center">
                                            <a href="<?= site_url('/app/province/edit/' . $prov['id']) ?>" 
                                               class="btn btn-sm btn-warning">
                                               <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <form action="<?= site_url('/app/province/delete/' . $prov['id']) ?>" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" 
                                                  class="d-inline-block">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    <?php endif; ?>
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
