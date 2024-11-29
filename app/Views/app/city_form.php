<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Kabupaten / Kota
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Tambah / Edit Kabupaten / Kota</h2>
    <form action="<?= site_url('/app/city/submit') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="id" value="<?= ($record_city !== null ? $record_city->id : "") ?>"> 
        
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Kabupaten / Kota</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Nama Kabupaten -->
                    <div class="col-md-6 mb-3">
                        <label for="city_name" class="form-label">Nama Kabupaten</label>
                        <input 
                            type="text" 
                            name="city_name" 
                            id="city_name" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_city !== null ? $record_city->city_name : "") ?>" 
                            placeholder="Masukkan Nama Kabupaten">
                    </div>
                    
                    <!-- Provinsi -->
                    <div class="col-md-6 mb-3">
                        <label for="prov_id" class="form-label">Provinsi</label>
                        <select name="prov_id" id="prov_id" class="form-select" required>
                            <option value="">-- Pilih Provinsi --</option>
                            <?php if (!empty($province)): ?>
                                <?php foreach ($province as $prov): ?>
                                    <option 
                                        value="<?= esc($prov['id']) ?>" 
                                        <?= ($record_city !== null && $record_city->prov_id == $prov['id'] ? 'selected' : '') ?>>
                                        <?= esc($prov['province_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <!-- Kode BPS -->
                    <div class="col-md-6 mb-3">
                        <label for="bps_code" class="form-label">Kode BPS</label>
                        <input 
                            type="text" 
                            name="bps_code" 
                            id="bps_code" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_city !== null ? $record_city->bps_code : "") ?>" 
                            placeholder="Masukkan Kode BPS">
                    </div>
                    
                    <!-- Kode Kemendagri -->
                    <div class="col-md-6 mb-3">
                        <label for="kemendagri_code" class="form-label">Kode Kemendagri</label>
                        <input 
                            type="text" 
                            name="kemendagri_code" 
                            id="kemendagri_code" 
                            class="form-control" 
                            maxlength="100" 
                            value="<?= ($record_city !== null ? $record_city->kemendagri_code : "") ?>" 
                            placeholder="Masukkan Kode Kemendagri">
                    </div>
                </div>
            </div>
            
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4">Simpan</button>
            </div>
        </div> 
    </form>
</div>

<?= $this->endSection() ?>
