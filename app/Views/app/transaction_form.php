<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Form Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2 class="text-center mt-4"><?= isset($transaction) ? 'Edit Transaksi' : 'Tambah Transaksi Baru' ?></h2>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= isset($transaction) ? site_url('/transaction/update/' . $transaction['id']) : site_url('/transaction/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="provinsi-dropdown" class="form-label">Pilih Provinsi</label>
                    <select class="form-select" name="provinsi" id="provinsi-dropdown" required>
                        <option value="">Pilih Provinsi</option>
                        <?php foreach ($provinsi as $prov): ?>
                            <option value="<?= esc($prov['kemendagri_code']) ?>" <?= isset($transaction) && $transaction['city_code'] === $prov['kemendagri_code'] ? 'selected' : '' ?>>
                                <?= esc($prov['province_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="city-dropdown" class="form-label">Pilih Kota</label>
                    <select class="form-select" name="city_code" id="city-dropdown" required>
                        <option value="">Pilih Kota</option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= esc($city['bps_code']) ?>" <?= isset($transaction) && $transaction['city_code'] === $city['bps_code'] ? 'selected' : '' ?>>
                                <?= esc($city['city_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="indicator_id" class="form-label">No. Indikator</label>
                    <input type="text" class="form-control" name="indicator_id" id="indicator_id" value="<?= isset($transaction) ? esc($transaction['indicator_id']) : '' ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="goal" class="form-label">Goal</label>
                    <input type="text" class="form-control" name="goal" id="goal" value="<?= isset($transaction) ? esc($transaction['goal']) : '' ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="value" class="form-label">Nilai</label>
                    <input type="number" class="form-control" name="value" id="value" value="<?= isset($transaction) ? esc($transaction['value']) : '' ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="growth_rate" class="form-label">Growth Rate</label>
                    <input type="number" class="form-control" name="growth_rate" id="growth_rate" value="<?= isset($transaction) ? esc($transaction['growth_rate']) : '' ?>">
                </div>
                <div class="col-md-4">
                    <label for="domain" class="form-label">Domain</label>
                    <select class="form-select" name="domain" id="domain" required>
                        <option value="">Pilih Domain</option>
                        <option value="1" <?= isset($transaction) && $transaction['domain'] === '1' ? 'selected' : '' ?>>Domain 1</option>
                        <option value="2" <?= isset($transaction) && $transaction['domain'] === '2' ? 'selected' : '' ?>>Domain 2</option>
                        <option value="3" <?= isset($transaction) && $transaction['domain'] === '3' ? 'selected' : '' ?>>Domain 3</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="year" class="form-label">Tahun</label>
                    <select class="form-select" name="year" id="year" required>
                        <option value="">Pilih Tahun</option>
                        <option value="2019" <?= isset($transaction) && $transaction['year'] === '2019' ? 'selected' : '' ?>>2019</option>
                        <option value="2020" <?= isset($transaction) && $transaction['year'] === '2020' ? 'selected' : '' ?>>2020</option>
                    </select>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary"><?= isset($transaction) ? 'Update' : 'Create' ?></button>
                <a href="<?= site_url('/transaction') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
