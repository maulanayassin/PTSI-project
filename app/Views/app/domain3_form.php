<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>
Domain 3
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Tambah / Edit Domain 3</h2>
<form action="<?= site_url('/app/domain3/submit') ?>" method="post">
<?= csrf_field() ?> 
<input type="hidden" name="id" id="id" value="<?= ($record_domain3 !== null ? $record_domain3->id : "") ?>">
<div class="card">
    <!-- <div class="card-header">
        <div class="card-actions">
            <button type="submit" class="btn btn-pill">Simpan</button>
        </div>
    </div> -->
    <div class="card-body">
        <div class="row">
            <div class="mb-3">
                <label class="form-label">No. Indikator</label>
                <input type="text" name="domain3_no" id="no_indicator" class="form-control" maxlength="100"  value="<?= ($record_domain3 !== null ? $record_domain3->no_indicator : "") ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Indikator</label>
                <input type="text" name="domain3_name" id="indicator_name" class="form-control" maxlength="100"  value="<?= ($record_domain3 !== null ? $record_domain3->indicator_name : "") ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" name="domain3_keterangan" id="information" class="form-control" maxlength="100"  value="<?= ($record_domain3 !== null ? $record_domain3->information : "") ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Tahun 2019</label>
                <input type="text" name="domain3_2019" id="year_2019" class="form-control" maxlength="100"  value="<?= ($record_domain3 !== null ? $record_domain3->year_2019 : "") ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Tahun 2020</label>
                <input type="text" name="domain3_2020" id="year_2020" class="form-control" maxlength="100"  value="<?= ($record_domain3 !== null ? $record_domain3->year_2020 : "") ?>">
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-pill btn-primary">Simpan</button>
    </div>
</div>
</form>


<?= $this->endSection() ?>