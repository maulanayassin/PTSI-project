<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Data Transaksi Provinsi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- <h2 class="text-center mt-4">Transaction Data</h2> -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="m-0">Data filter</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="provinsi-dropdown" class="form-label">Select Province</label>
                <select class="form-select" name="provinsi" id="provinsi-dropdown" required>
                    <option value="">Select Provinsi</option>
                    <?php foreach ($provinsi as $prov): ?>
                        <option value="<?= esc($prov['kemendagri_code']) ?>"><?= esc($prov['province_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="kota-dropdown" class="form-label">Select Regencies / Cities</label>
                <select class="form-select" name="kota" id="kota-dropdown" required>
                    <option value="">Select Regencies / Cities</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="tahun-dropdown" class="form-label">Select Year</label>
                <select class="form-select" name="tahun" id="tahun-dropdown" required>
                    <option value="">Select Year</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="domain-dropdown" class="form-label">Select Domain</label>
                <select class="form-select" name="domain" id="domain-dropdown" required>
                    <option value="">Select Domain</option>
                    <option value="1">Domain 1</option>
                    <option value="2">Domain 2</option>
                    <option value="3.1">Domain 3A</option>
                    <option value="3">Domain 3B</option>
                </select>
            </div>
        </div>
        <div class="text-end">
            <button id="refresh-button" class="btn btn-success me-2">
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
            <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= site_url('/app/transaction/form/' . (isset($transaction['id']) ? $transaction['id'] : '')) ?>" class="btn btn-success">Create New</a>
            <?php endif;?>
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
                <thead class="table-dark text-center">
                    <tr>
                        <th>Indicator Name</th>
                        <th>No. Indicator</th>
                        <th>Goal</th>
                        <th>Value</th>
                        <th>Growth Rate / Validation</th>
                        <?php if (session()->get('role') === 'admin'): ?>
                            <th>Action</th>
                        <?php endif;?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center">Please select province, city, and year to view data.</td>
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
            cell.colSpan = 6;
            cell.classList.add('text-center');
            cell.textContent = 'Tidak ada data untuk tahun yang dipilih.';
            return;
        }

        data.forEach(function(transaction) {
            let row = tableBody.insertRow();
            // Menambahkan sel dengan properti text-center
            row.insertCell(0).textContent = transaction.indicator_name;
            row.insertCell(1).textContent = transaction.indicator_id;
            row.cells[1].classList.add('text-center');
            row.insertCell(2).textContent = transaction.goal;
            row.cells[2].classList.add('text-center');
            row.insertCell(3).textContent = transaction.value_fix !== null ? transaction.value_fix : '-';
            row.cells[3].classList.add('text-center');
            row.insertCell(4).textContent = transaction.growth_rate !== null ? transaction.growth_rate : '-';
            row.cells[4].classList.add('text-center');
            <?php if (session()->get('role') === 'admin'): ?>
                let editCell = row.insertCell(5);
                // console.log(JSON.stringify(transaction));
                if (transaction.id !== 0) {
                    let editUrl = `${baseUrl}edit/${transaction.id}`;
                    editCell.innerHTML = `<a href="${editUrl}" class="btn btn-sm btn-primary">Edit</a>`;
                } else {
                    editCell.innerHTML = `<button class="btn btn-sm btn-secondary">Edit</button>`;
                }
            <?php endif;?>
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

    document.getElementById('refresh-button').addEventListener('click', function() {
        const domain = document.getElementById('domain-dropdown').value;
        const cityCode = document.getElementById('kota-dropdown').value;
        const year = document.getElementById('tahun-dropdown').value;
        const provinceCode = document.getElementById('provinsi-dropdown').value;

        console.log(domain); 

        console.log(domain + '-' + cityCode + '-' + provinceCode + '-' + year);
        console.log(`${baseUrl}processGrowth/${year}/${cityCode}/${provinceCode}/${domain}`);
        if (cityCode && year && domain) {
            fetch(`${baseUrl}processGrowth/${year}/${cityCode}/${provinceCode}/${domain}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                // console.log(data);
                renderTable(data);
            })
            .catch(error => console.error('Error fetching transaction data:', error));
        }
    });
</script>

<?= $this->endSection() ?>
