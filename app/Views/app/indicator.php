<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Indikator
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Daftar Indikator</h2>
<div class="card">
    <div class="card-header">
        <div class="card-actions align-items-center justify-content-between">
            <!-- Tombol Tambah di sebelah Dropdown -->
            <!-- <div class="d-inline-block"> -->
                <!-- Form untuk memilih Provinsi -->
                <!-- <form method="POST" action="<?= site_url('/app/indicator/selectProvince') ?>" class="d-inline"> -->
                    <!-- <select class="form-select d-inline w-8" name="kemendagri_code" id="provinsi-dropdown" onchange="this.form.submit()"> -->
                        <!-- <option value="">Pilih Provinsi</option> -->
                        <!-- <?php foreach ($provinsi as $prov): ?> -->
                            <!-- <option value="<?= esc($prov['kemendagri_code']) ?>"  -->
                                <!-- <?= isset($selectedProvinceCode) && $selectedProvinceCode == $prov['kemendagri_code'] ? 'selected' : '' ?>> -->
                                <!-- <?= esc($prov['province_name']) ?> -->
                            <!-- </option> -->
                        <!-- <?php endforeach; ?> -->
                    <!-- </select> -->
                <!-- </form> -->

                <!-- Dropdown Kota selalu tampil -->
                <!-- <form method="POST" action="<?= site_url('/app/indicator/selectCity') ?>" class="d-inline"> -->
                    <!-- <select class="form-select d-inline w-8" name="city_id" onchange="this.form.submit()"> -->
                        <!-- <option value="">Pilih Kota</option> -->
                        <!-- <?php if (isset($kota) && !empty($kota)): ?> -->
                            <!-- <?php foreach ($kota as $city): ?> -->
                                <!-- <option value="<?= esc($city['kemendagri_code']) ?>"  -->
                                    <!-- <?= isset($selectedCityId) && $selectedCityId == $city['kemendagri_code'] ? 'selected' : '' ?>> -->
                                    <!-- <?= esc($city['city_name']) ?> -->
                                <!-- </option> -->
                            <!-- <?php endforeach; ?> -->
                        <!-- <?php endif; ?> -->
                    <!-- </select> -->
                <!-- </form> -->
            <!-- </div> -->
            <!-- <div class="dropdown d-inline-block">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Pilih Domain
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?= site_url('app/domain1') ?>">Domain 1</a>
                    <a class="dropdown-item" href="<?= site_url('app/domain2') ?>">Domain 2</a>    
                    <a class="dropdown-item" href="<?= site_url('app/domain3') ?>">Domain 3</a>
                </div>
            </div> -->
            <a href="<?= site_url('/app/indicator/form') ?>" class="btn btn-pill">Tambah</a>
        </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped">
            <thead>
            <tr>
                <th>No. Indikator</th>
                <th>Nama Indikator</th>
                <th>goal</th>
                <th>Polaritas</th>
                <!-- <th>Tahun</th> -->
                <th>Sumber</th>
                <th class="w-8">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($data_indicator)): ?>
                <tr>
                    <td colspan="7">Tidak ada data</td>
                </tr>
            <?php else: ?>
                <?php foreach ($data_indicator as $indicator): ?>
                    <tr>
                        <td> <?= esc($indicator['no_indicator']) ?></td>
                        <td> <?= esc($indicator['indicator_name']) ?></td>
                        <td> <?= esc($indicator['goal'])?></td>
                        <td> <?= esc($indicator['polaritas']) ?></td>
                        <!-- <td> <?= esc($indicator['tahun']) ?></td> -->
                        <td> <?= esc($indicator['sumber'])?></td>
                        <td>
                            <a href="<?= site_url('/app/indicator/edit/' . $indicator['id']) ?>"class="btn btn-sm">Edit</a>  
                            <form action="<?= site_url('/app/indicator/delete/' . $indicator['id']) ?>" method = "POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline-block"><button type="submit" class="btn btn-sm ">Hapus</form>                                   
                        </td>
                    </tr>                            
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>  
    </div>
    </div>
</div>
 
<?= $this->endSection() ?>