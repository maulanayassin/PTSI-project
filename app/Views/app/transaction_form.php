<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Transaction
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Edit Transaction</h2>
<div class="card">
    <div class="card-body">
        <?php
        // Initialize the variables for year-specific values
        $value2019 = '';
        $value2020 = '';

        // Assuming $transaction['values'] contains an array of records with 'year' and 'value_fix'
        if (isset($transaction['values']) && is_array($transaction['values'])) {
            foreach ($transaction['values'] as $item) {
                if ($item['year'] == 2019) {
                    $value2019 = $item['value_fix'];
                } elseif ($item['year'] == 2020) {
                    $value2020 = $item['value_fix'];
                }
            }
        }
        ?>

        <!-- Form untuk mengedit data transaksi -->
        <form action="<?= site_url('/app/transaction/submit/') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $transaction['id'] ?>">

            <!-- Input Nama Kota -->
            <div class="mb-3">
                <label for="city_name" class="form-label">Nama Kota</label>
                <input type="text" class="form-control" id="city_name" name="city_name" value="<?= esc($transaction['city_name']) ?>" readonly>
            </div>

            <!-- Input No Indikator -->
            <div class="mb-3">
                <label for="indicator_id" class="form-label">No. Indikator</label>
                <input type="text" class="form-control" id="indicator_id" name="indicator_id" value="<?= esc($transaction['indicator_id']) ?>" readonly>
            </div>

            <!-- Input Goal -->
            <div class="mb-3">
                <label for="goal" class="form-label">Goal</label>
                <input type="text" class="form-control" id="goal" name="goal" value="<?= esc($transaction['goal']) ?>" required>
            </div>

            <!-- Input Tahun 2019 -->
            <div class="mb-3">
                <label for="year_2019" class="form-label">Tahun 2019</label>
                <input type="text" class="form-control" id="year_2019" name="year_2019" value="<?= esc($value2019) ?>" required>
            </div>

            <!-- Input Tahun 2020 -->
            <div class="mb-3">
                <label for="year_2020" class="form-label">Tahun 2020</label>
                <input type="text" class="form-control" id="year_2020" name="year_2020" value="<?= esc($value2020) ?>" required>
            </div>

            <!-- Dropdown Domain -->
            <div class="mb-3">
                <label for="domain" class="form-label">Domain</label>
                <select class="form-select" id="domain" name="domain" required>
                    <option value="1" <?= $transaction['domain'] == 1 ? 'selected' : '' ?>>Domain 1</option>
                    <option value="2" <?= $transaction['domain'] == 2 ? 'selected' : '' ?>>Domain 2</option>
                    <option value="3" <?= $transaction['domain'] == 3 ? 'selected' : '' ?>>Domain 3</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= site_url('/app/transaction') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
