<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Kabupaten / Kota
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Tambah / Edit ; Kabupaten / Kota</h2>
<form action="<?= site_url('/app/city/submit') ?>" method="post">
<?= csrf_field() ?>
<input type="hidden" name="id" id="id" value="<?= ($record_city !== null ? $record_city->id : "") ?>"> 
<div class="card">
    <!-- <div class="card-header">
        <div class="card-actions">
            <button type="submit" class="btn btn-pill">Simpan</button>
        </div>
    </div> -->
    <div class="card-body">
        <div class="row">
            <div class="form-group">
                <label class="form-label">Nama Kabupaten</label>
                <input type="text" name="city_name" id="city_name" class="form-control" maxlength="100" value="<?= ($record_city !== null ? $record_city->city_name : "") ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Provinsi</label>
                <select name="prov_id" id="prov_id" class="form-select" required>
                    <?php if (empty($province)): ?>
                        <option value="">-- Pilih Provinsi --</option>
                    <?php else: ?>
                        <?php foreach ($province as $prov): ?>
                            <option value="<?= esc($prov['id']) ?>">
                                <?= esc($prov['province_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>                
            </div>
        </div>
    </div>
     <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-pill btn-primary">Simpan</button>
    </div>
</div> 
</form>


<?= $this->endSection() ?>