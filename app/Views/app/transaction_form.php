<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Form Transaksi
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<h2 class="text-center mt-4"><?= isset($transaction) ? 'Edit Transaksi' : 'Buat Transaksi Baru' ?></h2>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="<?= site_url('/app/transaction/submit') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= isset($transaction) ? $transaction['id'] : '' ?>">

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="provinsi-dropdown" class="form-label">Pilih Provinsi</label>
                    <select class="form-select" name="provinsi" id="provinsi-dropdown">
                        <option value="">Pilih Provinsi</option>
                        <?php foreach ($provinsi as $prov): ?>
                            <option value="<?= esc($prov['kemendagri_code']) ?>" <?= (isset($transaction) && $transaction['province_id'] == $prov['kemendagri_code']) ? 'selected' : '' ?>>
                                <?= esc($prov['province_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="kota-dropdown" class="form-label">Pilih Kota</label>
                    <select class="form-select" name="kota" id="kota-dropdown">
                        <option value="">Pilih Kota</option>
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
                    <label for="nilai" class="form-label">Tahun</label>
                    <input type="number" class="form-control" name="tahun" id="tahun" value="<?= isset($transaction) ? esc($transaction['year']) : '' ?>" required min="2019" max="2099" step="1">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="domain-dropdown" class="form-label">Pilih Domain</label>
                    <select class="form-select" name="domain" id="domain-dropdown">
                        <option value="">Pilih Domain</option>
                        <option value="1" <?= (isset($transaction) && $transaction['domain'] == 1) ? 'selected' : '' ?>>Domain 1</option>
                        <option value="2" <?= (isset($transaction) && $transaction['domain'] == 2) ? 'selected' : '' ?>>Domain 2</option>
                        <option value="3" <?= (isset($transaction) && $transaction['domain'] == 3) ? 'selected' : '' ?>>Domain 3</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="indikator_name" class="form-label">Nama Indikator</label>
                <input type="text" class="form-control" name="indikator_name" id="indikator_name" value="<?= isset($transaction) ? esc($transaction['indicator_name']) : '' ?>" <?= isset($transaction)?>>
            </div>

            <div class="mb-3">
                <label for="goal" class="form-label">Goal</label>
                <input type="text" class="form-control" name="goal" id="goal" value="<?= isset($transaction) ? esc($transaction['goal']) : '' ?>" <?= isset($transaction)?>>
            </div>

            <div class="mb-3">
                <label for="nilai" class="form-label">Nilai</label>
                <input type="number" class="form-control" name="nilai" id="nilai" value="<?= isset($transaction) ? esc($transaction['value_fix']) : '' ?>" required>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <?= isset($transaction) ? 'Update Transaksi' : 'Buat Transaksi' ?>
                </button>
                <a href="<?= site_url('/app/transaction/submit') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const $provinceDropdown = $('#provinsi-dropdown');
        const $cityDropdown = $('#kota-dropdown');
        const $yearDropdown = $('#tahun-dropdown');
        const $domainDropdown = $('#domain-dropdown');

        // Fungsi untuk mengatur status dropdown (enable/disable)
        function setDropdownsState() {
            // if ($('#provinsi-dropdown').val()) {
            //     $provinceDropdown.prop('disabled', true);
            // } else {
            //     $provinceDropdown.prop('required', true);
            // }

            // if ($('#kota-dropdown').val()) {
            //     $cityDropdown.prop('disabled', true);
            // } else {
            //     $cityDropdown.prop('required', true);
            // }

            if ($('#tahun-dropdown').val()) {
                $yearDropdown.prop('disabled', true);
            } else {
                $yearDropdown.prop('required', true);
            }

            // if ($('#domain-dropdown').val()) {
            //     $domainDropdown.prop('disabled', true);
            // } else {
            //     $domainDropdown.prop('required', true);
            // }
        }

        setDropdownsState(); // Set initial state for dropdowns

        // Fungsi untuk menangani perubahan pada dropdown provinsi
        $provinceDropdown.on('change', function () {
            const provinceId = $(this).val();
            if (provinceId) {
                fetchCitiesByProvince(provinceId);
            } else {
                resetCityDropdown();
            }
        });

        // Fungsi untuk mengambil data kota berdasarkan provinsi
        function fetchCitiesByProvince(provinceId) {
            $.ajax({
                url: `<?= site_url('/app/transaction/getCitiesByProvince') ?>/${provinceId}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    populateCityDropdown(data);
                    // If there is a previous transaction, select the city
                    if ('<?= isset($transaction) ? $transaction['city_name'] : '' ?>') {
                        const selectedCity = '<?= isset($transaction) ? $transaction['city_name'] : '' ?>';
                        $cityDropdown.val(selectedCity);
                    }
                },
                error: function () {
                    alert("Error loading cities. Please try again.");
                }
            });
        }

        // Fungsi untuk mengisi dropdown kota dengan data yang diterima
        function populateCityDropdown(data) {
            resetCityDropdown();
            $.each(data, function (key, value) {
                $cityDropdown.append(`<option value="${value.bps_code}">${value.city_name}</option>`);
            });
        }

        // Fungsi untuk mereset dropdown kota
        function resetCityDropdown() {
            $cityDropdown.empty().append('<option value="">Pilih Kota</option>');
        }
    });

</script>
<?= $this->endSection() ?>
