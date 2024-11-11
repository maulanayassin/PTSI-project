<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2 class="text-center mt-4">Edit Data Transaksi</h2>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="<?= site_url('/app/transaction/update/' . $transaction['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="indicator_name" class="form-label">Nama Indikator</label>
                <input type="text" name="indicator_name" class="form-control" value="<?= esc($transaction['indicator_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="goal" class="form-label">Goal</label>
                <input type="text" name="goal" class="form-control" value="<?= esc($transaction['goal']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="value_fix" class="form-label">Nilai</label>
                <input type="number" step="any" name="value_fix" class="form-control" value="<?= esc($transaction['value_fix']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="growth_rate" class="form-label">Growth Rate</label>
                <input type="number" step="any" name="growth_rate" class="form-control" value="<?= esc($transaction['growth_rate']) ?>" required>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= site_url('/app/transaction') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
