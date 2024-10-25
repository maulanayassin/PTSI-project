<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Form Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Form Transaksi</h2>
<div class="card">
    <div class="card-body">
        <form action="<?= site_url('/app/transaction/submit') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= isset($transaksi) ? esc($transaksi['id']) : '' ?>">

            <!-- Dropdown Provinsi -->
            <div class="form-group mb-3">
                <label for="provinsi">Provinsi</label>
                <select class="form-select" name="provinsi" id="provinsi-dropdown" required>
                    <option value="">Pilih Provinsi</option>
                    <?php foreach ($provinsi as $prov): ?>
                        <option value="<?= esc($prov['kemendagri_code']) ?>"
                            <?= isset($transaksi) && $transaksi['province_id'] == $prov['kemendagri_code'] ? 'selected' : '' ?>>
                            <?= esc($prov['province_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Dropdown Kota -->
            <div class="form-group mb-3">
                <label for="kota">Kota</label>
                <select class="form-select" name="city_id" id="kota-dropdown" required>
                    <option value="">Pilih Kota</option>
                    <!-- Dropdown kota akan diisi secara dinamis melalui AJAX -->
                </select>
            </div>

            <!-- Input No Indikator -->
            <div class="form-group mb-3">
                <label for="indicator_id">No. Indikator</label>
                <input type="text" class="form-control" name="indicator_id" value="<?= isset($transaksi) ? esc($transaksi['indicator_id']) : '' ?>" required>
            </div>

            <!-- Input Goal -->
            <div class="form-group mb-3">
                <label for="goal">Goal</label>
                <input type="text" class="form-control" name="goal" value="<?= isset($transaksi) ? esc($transaksi['goal']) : '' ?>" required>
            </div>

            <!-- Input Tahun 2019 -->
            <div class="form-group mb-3">
                <label for="year_2019">Tahun 2019</label>
                <input type="number" class="form-control" name="year_2019" value="<?= isset($transaksi) ? esc($transaksi['year_2019']) : '' ?>">
            </div>

            <!-- Input Tahun 2020 -->
            <div class="form-group mb-3">
                <label for="year_2020">Tahun 2020</label>
                <input type="number" class="form-control" name="year_2020" value="<?= isset($transaksi) ? esc($transaksi['year_2020']) : '' ?>">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= site_url('/app/transaction') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
    document.getElementById('provinsi-dropdown').addEventListener('change', function() {
        let provinceCode = this.value;

        if (provinceCode) {
            fetch('<?= site_url('/app/transaction/getCities') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                },
                body: JSON.stringify({ provinceCode: provinceCode })
            })
            .then(response => response.json())
            .then(data => {
                let kotaDropdown = document.getElementById('kota-dropdown');
                kotaDropdown.innerHTML = '<option value="">Pilih Kota</option>';
                data.forEach(function(city) {
                    let option = document.createElement('option');
                    option.value = city.bps_code;
                    option.text = city.city_name;
                    kotaDropdown.appendChild(option);
                });

                // Jika sedang mengedit data, atur kota yang sesuai
                <?php if (isset($transaksi)): ?>
                    kotaDropdown.value = '<?= esc($transaksi['city_id']) ?>';
                <?php endif; ?>
            })

            .catch(error => console.error('Error fetching cities:', error));
        }
    });

    // Trigger change event to load cities if editing existing transaction
    <?php if (isset($transaksi)): ?>
        document.getElementById('provinsi-dropdown').dispatchEvent(new Event('change'));
    <?php endif; ?>
</script>

<?= $this->endSection() ?>
