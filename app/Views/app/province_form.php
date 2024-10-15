<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>
province
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Tambah / Edit Provinsi</h2>
<form action="<?= site_url('/app/province/submit') ?>" method="post">
<?= csrf_field() ?> 
<input type="hidden" name="id" id="id" value="<?= ($record_province !== null ? $record_province->id : "") ?>">
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="mb-3">
                <label class="form-label">Nama Provinsi</label>
                <input type="text" name="province_name" id="province_name" class="form-control" maxlength="100"  value="<?= ($record_province !== null ? $record_province->province_name : "") ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Kode BPS</label>
                <input type="text" name="bps_code" id="bps_code" class="form-control" maxlength="100"  value="<?= ($record_province !== null ? $record_province->bps_code : "") ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Kode Kemendagri</label>
                <input type="text" name="kemendagri_code" id="kemendagri_code" class="form-control" maxlength="100"  value="<?= ($record_province !== null ? $record_province->kemendagri_code : "") ?>">
            </div>
        </div> 
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-pill btn-primary">Simpan</button>
    </div>
</div>
</form>


<?= $this->endSection() ?>