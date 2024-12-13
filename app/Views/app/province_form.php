<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Provinsi
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Add / Edit Province</h2>
    <form action="<?= site_url('/app/province/submit') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="id" value="<?= ($record_province !== null ? $record_province->id : "") ?>">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Provincial Form</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Nama Provinsi -->
                    <div class="col-md-6 mb-3">
                        <label for="province_name" class="form-label">Province Name</label>
                        <input 
                            type="text" 
                            name="province_name" 
                            id="province_name" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_province !== null ? $record_province->province_name : "") ?>" 
                            placeholder="Masukkan Nama Provinsi">
                    </div>

                    <!-- Kode BPS -->
                    <div class="col-md-6 mb-3">
                        <label for="bps_code" class="form-label">BPS Code</label>
                        <input 
                            type="text" 
                            name="bps_code" 
                            id="bps_code" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_province !== null ? $record_province->bps_code : "") ?>" 
                            placeholder="Masukkan Kode BPS">
                    </div>

                    <!-- Kode Kemendagri -->
                    <div class="col-md-6 mb-3">
                        <label for="kemendagri_code" class="form-label">Kemendagri Code</label>
                        <input 
                            type="text" 
                            name="kemendagri_code" 
                            id="kemendagri_code" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_province !== null ? $record_province->kemendagri_code : "") ?>" 
                            placeholder="Masukkan Kode Kemendagri">
                    </div>
                </div>
            </div>
            
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4">Save</button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
