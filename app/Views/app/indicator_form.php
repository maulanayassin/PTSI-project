<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>
Indikator
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Tambah / Edit Indikator</h2>
<form action="<?= site_url('/app/indicator/submit') ?>" method="post">
<?= csrf_field() ?> 
<input type="hidden" name="id" id="id" value="<?= ($record_indicator !== null ? $record_indicator->id : "") ?>">
<div class="card">
    <div class="card-header">
        <div class="card-actions">
            <button type="submit" class="btn btn-pill">Simpan</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="mb-3">
                <label class="form-label">No. Indikator</label>
                <input type="text" name="indicator_no" id="no_indicator" class="form-control" maxlength="100"  value="<?= ($record_indicator !== null ? $record_indicator->no_indicator : "") ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Indikator</label>
                <input type="text" name="indicator_name" id="indicator_name" class="form-control" maxlength="100"  value="<?= ($record_indicator !== null ? $record_indicator->indicator_name : "") ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Goal</label>
                <input type="text" name="goal" id="goal" class="form-control" maxlength="100"  value="<?= ($record_indicator !== null ? $record_indicator->goal : "") ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Polaritas</label>
                <input type="text" name="polaritas" id="polaritas" class="form-control" maxlength="100"  value="<?= ($record_indicator !== null ? $record_indicator->polaritas : "") ?>">
            </div>
            <!-- <div class="mb-3">
                <label class="form-label">Tahun</label>
                <input type="text" name="tahun" id="tahun" class="form-control" maxlength="100"  value="<?= ($record_indicator !== null ? $record_indicator->tahun : "") ?>">
            </div> -->
            <div class="mb-3">
                <label class="form-label">Sumber</label>
                <input type="text" name="sumber" id="sumber" class="form-control" maxlength="100"  value="<?= ($record_indicator !== null ? $record_indicator->sumber : "") ?>">
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-pill btn-primary">Simpan</button>
    </div>
</div>
</form>


<?= $this->endSection() ?>