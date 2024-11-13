<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Form Transaksi
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<h2 class="text-center mt-4"><?= isset($transaksi) ? 'Edit Transaksi' : 'Buat Transaksi Baru' ?></h2>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="<?= site_url('/app/transaction/submit') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= isset($transaksi) ? $transaksi['id'] : '' ?>">

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="provinsi-dropdown" class="form-label">Pilih Provinsi</label>
                    <select class="form-select" name="provinsi" id="provinsi-dropdown" required>
                        <option value="">Pilih Provinsi</option>
                        <?php foreach ($provinsi as $prov): ?>
                            <option value="<?= esc($prov['kemendagri_code']) ?>" <?= (isset($transaksi) && $transaksi['provinsi'] == $prov['kemendagri_code']) ? 'selected' : '' ?>>
                                <?= esc($prov['province_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="kota-dropdown" class="form-label">Pilih Kota</label>
                    <select class="form-select" name="kota" id="kota-dropdown" required>
                        <option value="">Pilih Kota</option>
                        <?php if (isset($transaksi)): ?>
                            <?php foreach ($kota as $city): ?>
                                <option value="<?= esc($city['id']) ?>" <?= ($transaksi['kota'] == $city['id']) ? 'selected' : '' ?>>
                                    <?= esc($city['city_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="tahun-dropdown" class="form-label">Pilih Tahun</label>
                    <select class="form-select" name="tahun" id="tahun-dropdown" required>
                        <option value="">Pilih Tahun</option>
                        <option value="2019" <?= (isset($transaksi) && $transaksi['year'] == 2019) ? 'selected' : '' ?>>2019</option>
                        <option value="2020" <?= (isset($transaksi) && $transaksi['year'] == 2020) ? 'selected' : '' ?>>2020</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="domain-dropdown" class="form-label">Pilih Domain</label>
                    <select class="form-select" name="domain" id="domain-dropdown" required>
                        <option value="">Pilih Domain</option>
                        <option value="1" <?= (isset($transaksi) && $transaksi['domain'] == 1) ? 'selected' : '' ?>>Domain 1</option>
                        <option value="2" <?= (isset($transaksi) && $transaksi['domain'] == 2) ? 'selected' : '' ?>>Domain 2</option>
                        <option value="3" <?= (isset($transaksi) && $transaksi['domain'] == 3) ? 'selected' : '' ?>>Domain 3</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="indikator_name" class="form-label">Nama Indikator</label>
                <input type="text" class="form-control" name="indikator_name" id="indikator_name" value="<?= isset($transaksi) ? esc($transaksi['indicator_name']) : '' ?>" required>
            </div>

            <div class="mb-3">
                <label for="no_indikator" class="form-label">No. Indikator</label>
                <input type="text" class="form-control" name="no_indikator" id="no_indikator" value="<?= isset($transaksi) ? esc($transaksi['indicator_id']) : '' ?>" required>
            </div>

            <div class="mb-3">
                <label for="goal" class="form-label">Goal</label>
                <input type="text" class="form-control" name="goal" id="goal" value="<?= isset($transaksi) ? esc($transaksi['goal']) : '' ?>" required>
            </div>

            <div class="mb-3">
                <label for="nilai" class="form-label">Nilai</label>
                <input type="number" class="form-control" name="nilai" id="nilai" value="<?= isset($transaksi) ? esc($transaksi['value_fix']) : '' ?>" required>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <?= isset($transaksi) ? 'Update Transaksi' : 'Buat Transaksi' ?>
                </button>
                <a href="<?= site_url('/app/transaction') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>