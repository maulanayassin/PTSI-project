<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>
Indikator
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Create / Edit Indikator</h2>
    <form action="<?= site_url('/app/indicator/submit') ?>" method="post">
        <?= csrf_field() ?> 
        <input type="hidden" name="id" id="id" value="<?= ($record_indicator !== null ? $record_indicator->id : "") ?>">
        
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Indicator Form</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- No. Indikator -->
                    <div class="col-md-6 mb-3">
                        <label for="no_indicator" class="form-label">No. Indicator</label>
                        <input 
                            type="text" 
                            name="no_indicator" 
                            id="no_indicator" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_indicator !== null ? $record_indicator->no_indicator : "") ?>" 
                            placeholder="Masukkan No. Indikator">
                    </div>
                    
                    <!-- Nama Indikator -->
                    <div class="col-md-6 mb-3">
                        <label for="indicator_name" class="form-label">Indicator Name</label>
                        <input 
                            type="text" 
                            name="indicator_name" 
                            id="indicator_name" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_indicator !== null ? $record_indicator->indicator_name : "") ?>" 
                            placeholder="Masukkan Nama Indikator">
                    </div>
                    
                    <!-- Goal -->
                    <div class="col-md-6 mb-3">
                        <label for="goal" class="form-label">Goal</label>
                        <input 
                            type="text" 
                            name="goal" 
                            id="goal" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_indicator !== null ? $record_indicator->goal : "") ?>" 
                            placeholder="Masukkan Goal">
                    </div>
                    
                    <!-- Domain -->
                    <div class="col-md-6 mb-3">
                        <label for="domain" class="form-label">Domain</label>
                        <input 
                            type="text" 
                            name="domain" 
                            id="domain" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_indicator !== null ? $record_indicator->domain : "") ?>" 
                            placeholder="Masukkan Domain">
                    </div>
                    
                    <!-- Polaritas -->
                    <div class="col-md-6 mb-3">
                        <label for="polaritas" class="form-label">Polarity</label>
                        <input 
                            type="text" 
                            name="polaritas" 
                            id="polaritas" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_indicator !== null ? $record_indicator->polaritas : "") ?>" 
                            placeholder="Masukkan Polaritas">
                    </div>
                    
                    <!-- Tahun -->
                    <div class="col-md-6 mb-3">
                        <label for="tahun" class="form-label">Year</label>
                        <input 
                            type="text" 
                            name="tahun" 
                            id="tahun" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_indicator !== null ? $record_indicator->tahun : "") ?>" 
                            placeholder="Masukkan Tahun">
                    </div>
                    
                    <!-- Sumber -->
                    <div class="col-md-6 mb-3">
                        <label for="sumber" class="form-label">Source</label>
                        <input 
                            type="text" 
                            name="sumber" 
                            id="sumber" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_indicator !== null ? $record_indicator->sumber : "") ?>" 
                            placeholder="Masukkan Sumber">
                    </div>
                </div>
            </div>
            
            <!-- Tombol Simpan -->
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-pill px-4">SAve</button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
