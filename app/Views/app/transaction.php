<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Provinsi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2 class="text-center mt-4">Data Transaksi</h2>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="m-0">Filter Data</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="provinsi-dropdown" class="form-label">Pilih Provinsi</label>
                <select class="form-select" name="provinsi" id="provinsi-dropdown" required>
                    <option value="">Pilih Provinsi</option>
                    <?php foreach ($provinsi as $prov): ?>
                        <option value="<?= esc($prov['kemendagri_code']) ?>"><?= esc($prov['province_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="kota-dropdown" class="form-label">Pilih Kota</label>
                <select class="form-select" name="kota" id="kota-dropdown" required>
                    <option value="">Pilih Kota</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="tahun-dropdown" class="form-label">Pilih Tahun</label>
                <select class="form-select" name="tahun" id="tahun-dropdown" required>
                    <option value="">Pilih Tahun</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="domain-dropdown" class="form-label">Pilih Domain</label>
                <select class="form-select" name="domain" id="domain-dropdown" required disabled>
                    <option value="">Pilih Domain</option>
                    <option value="1">Domain 1</option>
                    <option value="2">Domain 2</option>
                    <option value="3">Domain 3</option>
                </select>
            </div>
        </div>
        <div class="text-end">
            <button id="refresh-button" class="btn btn-secondary me-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path></svg>
                <i class="bi bi-arrow-repeat"></i> Refresh
            </button>
            <!-- <button id="edit-button" class="btn btn-secondary me-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                        <path d="M13.5 6.5l4 4"></path>
                        <path d="M16 19h6"></path>
                        <path d="M19 16v6"></path></svg>
                <i class="bi bi-arrow-repeat"></i> Edit
            </button> -->
            <a href="<?= isset($transaction['id']) ? site_url('/app/transaction/edit/' . $transaction['id']) : '#' ?>" class="btn btn-secondary me-2" <?= isset($transaction['id']) ? '' : 'disabled' ?>>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                    <path d="M13.5 6.5l4 4"></path>
                    <path d="M16 19h6"></path>
                    <path d="M19 16v6"></path>
                </svg>Edit
            </a>
             <a href="<?= isset($transaction) ? site_url('/app/transaction/form/' . $transaction['id']) : '#' ?>" class="btn btn-success" <?= isset($transaction) ? '' : 'disabled' ?>>Create New</a>
            <!-- <button id="process-button" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Create New
            </button> -->
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="transaction-table">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Kota</th>
                        <th>No. Indikator</th>
                        <th>Goal</th>
                        <th>Nilai</th>
                        <th>Growth Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center">Silahkan pilih provinsi, kota, dan tahun untuk melihat data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const baseUrl = '<?= site_url('/app/transaction/') ?>';
    const csrfToken = '<?= csrf_hash() ?>';

    function populateDropdown(dropdown, options) {
        dropdown.innerHTML = '<option value="">Pilih Kota</option>';
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.bps_code;
            opt.textContent = option.city_name;
            dropdown.appendChild(opt);
        });
    }

    function renderTable(data) {
        const tableBody = document.getElementById('transaction-table').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = ''; // Clear existing rows

        if (data.length === 0) {
            let row = tableBody.insertRow();
            let cell = row.insertCell(0);
            cell.colSpan = 5;
            cell.classList.add('text-center');
            cell.textContent = 'Tidak ada data untuk tahun yang dipilih.';
            return;
        }

        data.forEach(function(transaction) {
            let row = tableBody.insertRow();
            row.insertCell(0).textContent = transaction.city_name;
            row.insertCell(1).textContent = transaction.indicator_id;
            row.insertCell(2).textContent = transaction.goal;
            row.insertCell(3).textContent = transaction.value_fix !== null ? transaction.value_fix : '-';
            row.insertCell(4).textContent = transaction.growth !== null ? transaction.growth : '-';
        });
    }

    document.getElementById('provinsi-dropdown').addEventListener('change', function() {
        const provinceCode = this.value;
        if (provinceCode) {
            fetch(`${baseUrl}getCities`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ provinceCode: provinceCode })
            })
            .then(response => response.json())
            .then(data => populateDropdown(document.getElementById('kota-dropdown'), data))
            .catch(error => console.error('Error fetching city data:', error));
        } else {
            document.getElementById('kota-dropdown').innerHTML = '<option value="">Pilih Kota</option>';
        }
    });

    document.getElementById('kota-dropdown').addEventListener('change', function() {
        const cityCode = this.value;
        const year = document.getElementById('tahun-dropdown').value;
        const domain = document.getElementById('domain-dropdown').value;
        const provinceCode = document.getElementById('provinsi-dropdown').value;

        if (cityCode && year && domain) {
            fetch(`${baseUrl}processGrowth/${year}/${cityCode}/${provinceCode}/${domain}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => renderTable(data))
            .catch(error => console.error('Error fetching transaction data:', error));
        }
    });

    document.getElementById('tahun-dropdown').addEventListener('change', function() {
        const year = this.value;
        const cityCode = document.getElementById('kota-dropdown').value;
        const domain = document.getElementById('domain-dropdown').value;
        const provinceCode = document.getElementById('provinsi-dropdown').value;

        if (cityCode && year && domain) {
            fetch(`${baseUrl}processGrowth/${year}/${cityCode}/${provinceCode}/${domain}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => renderTable(data))
            .catch(error => console.error('Error fetching transaction data:', error));
        }
    });

    document.getElementById('domain-dropdown').addEventListener('change', function() {
        const domain = this.value;
        const cityCode = document.getElementById('kota-dropdown').value;
        const year = document.getElementById('tahun-dropdown').value;
        const provinceCode = document.getElementById('provinsi-dropdown').value;

        if (cityCode && year && domain) {
            fetch(`${baseUrl}processGrowth/${year}/${cityCode}/${provinceCode}/${domain}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => renderTable(data))
            .catch(error => console.error('Error fetching transaction data:', error));
        }
    });


    document.getElementById('refresh-button').addEventListener('click', function() {
        document.getElementById('provinsi-dropdown').selectedIndex = 0;
        document.getElementById('kota-dropdown').innerHTML = '<option value="">Pilih Kota</option>';
        document.getElementById('domain-dropdown').innerHTML = '<option value="">Pilih Domain</option>';
        document.getElementById('domain-dropdown').disabled = true;
        const tableBody = document.getElementById('transaction-table').querySelector('tbody');
        tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Silahkan pilih provinsi, kota, dan tahun untuk melihat data.</td></tr>';
    });

</script>

<?= $this->endSection() ?>
