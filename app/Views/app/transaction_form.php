<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Transaction Form
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Edit Transaksi</h2>
<div class="card">
    <div class="card-body">
        <!-- Form untuk membuat atau memperbarui transaksi -->
        <form action="<?= site_url('/app/transaction/submit/') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Hidden input untuk menyimpan ID transaksi jika sudah ada -->
            <input type="hidden" name="id" value="<?= isset($transaction['id']) ? $transaction['id'] : '' ?>">

            <!-- Input Nama Kota (readonly, untuk keperluan tampilan saja) -->
            <div class="mb-3">
                <label for="city_name" class="form-label">Nama Kota</label>
                <input type="text" class="form-control" id="city_name" name="city_name" 
                       value="<?= isset($transaction['city_name']) ? esc($transaction['city_name']) : '' ?>" 
                       readonly>
            </div>

            <!-- Input No. Indikator (readonly, untuk keperluan tampilan saja) -->
            <div class="mb-3">
                <label for="indicator_id" class="form-label">No. Indikator</label>
                <input type="text" class="form-control" id="indicator_id" name="indicator_id" 
                       value="<?= isset($transaction['indicator_id']) ? esc($transaction['indicator_id']) : '' ?>" 
                       readonly>
            </div>

            <!-- Input Goal (wajib diisi) -->
            <div class="mb-3">
                <label for="goal" class="form-label">Goal</label>
                <input type="text" class="form-control" id="goal" name="goal" 
                       value="<?= isset($transaction['goal']) ? esc($transaction['goal']) : '' ?>" 
                       required>
            </div>

            <div class="mb-3">
                <label for="year_2019" class="form-label">Tahun 2019</label>
                <input type="number" class="form-control" name="year_2019" id="year_2019"
                       value="<?= isset($transaction['year_2019']) ? esc($transaction['year_2019']) : '' ?>">
            </div>

            <div class="mb-3">
                <label for="year_2020" class="form-label">Tahun 2020</label>
                <input type="number" class="form-control" name="year_2020" id="year_2020"
                       value="<?= isset($transaction['year_2020']) ? esc($transaction['year_2020']) : '' ?>">
            </div>

            <div class="mb-3">
                <label for="growth_rate" class="form-label">Growth Rate</label>
                <input type="text" class="form-control" name="growth_rate" id="growth_rate"
                       value="<?= esc($transaction['growth_rate']) ?>" readonly>
            </div>

            <!-- Dropdown Domain (wajib diisi) -->
            <div class="mb-3">
                <label for="domain" class="form-label">Domain</label>
                <select class="form-select" id="domain" name="domain" required>
                    <option value="1" <?= isset($transaction['domain']) && $transaction['domain'] == 1 ? 'selected' : '' ?>>Domain 1</option>
                    <option value="2" <?= isset($transaction['domain']) && $transaction['domain'] == 2 ? 'selected' : '' ?>>Domain 2</option>
                    <option value="3" <?= isset($transaction['domain']) && $transaction['domain'] == 3 ? 'selected' : '' ?>>Domain 3</option>
                </select>
            </div>

            <!-- Submit dan Cancel Button -->
            <div class="mb-3 text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= site_url('/app/transaction') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
