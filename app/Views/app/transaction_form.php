<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Form Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2 class="text-center mt-4"><?= isset($transaction) ? 'Edit Transaction' : 'Create New Transaction' ?></h2>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="<?= site_url('/app/transaction/submit') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= isset($transaction) ? $transaction['id'] : '' ?>">

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="provinsi-dropdown" class="form-label">Select Province</label>
                    <select class="form-select" name="provinsi" id="provinsi-dropdown">
                        <option value="">Select Province</option>
                        <?php foreach ($provinsi as $prov): ?>
                            <option value="<?= esc($prov['kemendagri_code']) ?>" <?= (isset($transaction) && $transaction['province_id'] == $prov['kemendagri_code']) ? 'selected' : '' ?>>
                                <?= esc($prov['province_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="kota-dropdown" class="form-label">Select Regencies / Cities</label>
                    <select class="form-select" name="kota" id="kota-dropdown">
                        <option value="">Select Regencies / Cities</option>
                        <?php if (isset($cities) && !empty($cities)): ?>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?= esc($city['id']) ?>" <?= (isset($transaction) && $transaction['kota'] == $city['bps_code']) ? 'selected' : '' ?>>
                                    <?= esc($city['city_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="nilai" class="form-label">Year</label>
                    <input type="number" class="form-control" name="tahun" id="tahun" value="<?= isset($transaction) ? esc($transaction['year']) : '' ?>" required min="2019" max="2099" step="1">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="domain-dropdown" class="form-label">Select Domain</label>
                    <select class="form-select" name="domain" id="domain-dropdown">
                        <option value="">Pilih Domain</option>
                        <option value="1" <?= (isset($transaction) && $transaction['domain'] == 1) ? 'selected' : '' ?>>Domain 1</option>
                        <option value="2" <?= (isset($transaction) && $transaction['domain'] == 2) ? 'selected' : '' ?>>Domain 2</option>
                        <option value="3.1" <?= (isset($transaction) && $transaction['domain'] == 3.1) ? 'selected' : '' ?>>Domain 3A</option>
                        <option value="3" <?= (isset($transaction) && $transaction['domain'] == 3) ? 'selected' : '' ?>>Domain 3B</option>
                    </select>
                </div>
            </div>

            <!-- Dynamic Form Section -->
            <div id="dynamic-form">
                <!-- This section will be dynamically updated by JavaScript -->
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <?= isset($transaction) ? 'Save Transaction' : 'Save New Transaction' ?>
                </button>
                <a href="<?= site_url('/app/transaction/batal?' . http_build_query([
                    'provinsi' => isset($transaction) ? rawurlencode($transaction['province_id']) : '',
                    'kota' => isset($transaction) ? rawurlencode($transaction['city_name']) : '',
                    'tahun' => isset($transaction) ? rawurlencode($transaction['year']) : '',
                    'domain' => isset($transaction) ? rawurlencode(str_replace('.', '', $transaction['domain'])) : '' // Menghapus titik
                ])) ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const $provinceDropdown = $('#provinsi-dropdown');
    const $cityDropdown = $('#kota-dropdown');

    function fetchCities(provinceId) {
        if (!provinceId) {
            $cityDropdown.empty().append('<option value="">Select Regencies / Cities</option>');
            return;
        }

        $.ajax({
            url: `<?= site_url('/app/transaction/getCitiesByProvince') ?>/${provinceId}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $cityDropdown.empty().append('<option value="">Select Regencies / Cities</option>');
                data.forEach(city => {
                    $cityDropdown.append(`<option value="${city.bps_code}">${city.city_name}</option>`);
                });
            },
            error: function() {
                alert('Gagal memuat data kota!');
            }
        });
    }

    $provinceDropdown.on('change', function() {
        const provinceId = $(this).val();
        fetchCities(provinceId);
    });

    $(document).ready(function () {
        const $domainDropdown = $('#domain-dropdown');
        const $dynamicForm = $('#dynamic-form');

        function updateForm(domain) {
            let formContent = '';

            switch (domain) {
                case '1':
                    formContent = `
                        <div class="mb-3">
                            <label for="indikator_name" class="form-label">Nama Indikator</label>
                            <input type="text" class="form-control" name="indikator_name" id="indikator_name" 
                                value="<?= isset($transaction) ? esc($transaction['indicator_name']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="goal" class="form-label">Goal</label>
                            <input type="text" class="form-control" name="goal" id="goal" 
                                value="<?= isset($transaction) ? esc($transaction['goal']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan Nilai</label>
                            <textarea class="form-control" name="ket_nilai" id="ket_nilai" required><?= isset($transaction) ? esc($transaction['value']) : '' ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="nilai" class="form-label">Nilai</label>
                            <input type="number" class="form-control" name="nilai" id="nilai" 
                                value="<?= isset($transaction) ? esc($transaction['value_fix']) : '' ?>" required>
                        </div>`;
                    break;
                case '2':
                case '3.1':
                    formContent = `
                        <div class="mb-3">
                            <label for="indikator_name" class="form-label">Nama Indikator</label>
                            <input type="text" class="form-control" name="indikator_name" id="indikator_name" 
                                value="<?= isset($transaction) ? esc($transaction['indicator_name']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="goal" class="form-label">Goal</label>
                            <input type="text" class="form-control" name="goal" id="goal" 
                                value="<?= isset($transaction) ? esc($transaction['goal']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan Nilai</label>
                            <textarea class="form-control" name="keterangan" id="ket_nilai" required><?= isset($transaction) ? esc($transaction['value']) : '' ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="verification" class="form-label">Verification</label>
                            <input type="text" class="form-control" name="verification" id="verification" 
                                value="<?= isset($transaction) ? esc($transaction['verification']) : '' ?>" required>
                        </div>`;
                    break;
                case '3':
                    formContent = `
                        <div class="mb-3">
                            <label for="indikator_name" class="form-label">Nama Indikator</label>
                            <input type="text" class="form-control" name="indikator_name" id="indikator_name" 
                                value="<?= isset($transaction) ? esc($transaction['indicator_name']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="goal" class="form-label">Goal</label>
                            <input type="text" class="form-control" name="goal" id="goal" 
                                value="<?= isset($transaction) ? esc($transaction['goal']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan Nilai</label>
                            <textarea class="form-control" name="ket_nilai" id="ket_nilai" required><?= isset($transaction) ? esc($transaction['value']) : '' ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="nilai" class="form-label">Nilai</label>
                            <input type="number" class="form-control" name="nilai" id="nilai" 
                                value="<?= isset($transaction) ? esc($transaction['value_fix']) : '' ?>" required>
                        </div>`;
                    break;
                default:
                    formContent = '<p class="text-muted">Pilih domain untuk menampilkan form.</p>';
            }

            $dynamicForm.html(formContent);
        }

        // Initialize form based on selected domain (if editing)
        updateForm($domainDropdown.val());

        // Update form when domain changes
        $domainDropdown.on('change', function () {
            updateForm($(this).val());
        });
    });
</script>
<?= $this->endSection() ?>
