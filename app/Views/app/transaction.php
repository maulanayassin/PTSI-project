<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Provinsi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Data Provinsi</h2>
<div class="card">
    <div class="card-header">
        <div class="card-actions">
            <!-- Form untuk memilih Provinsi -->
            <form class="d-inline" id="provinsi-form">
                <select class="form-select d-inline w-8" name="provinsi" id="provinsi-dropdown" required>
                    <option value="">Pilih Provinsi</option>
                    <?php foreach ($provinsi as $prov): ?>
                        <option value="<?= esc($prov['kemendagri_code']) ?>">
                            <?= esc($prov['province_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <!-- Dropdown untuk Kota, akan diisi melalui AJAX -->
            <form class="d-inline" id="kota-form">
                <select class="form-select d-inline w-8" name="kota" id="kota-dropdown" required>
                    <option value="">Pilih Kota</option>
                </select>
            </form>
            <!-- <a href="<?= site_url('/app/transaction/form') ?>" class="btn btn-pill">Tambah</a> -->
             <form class="d-inline" id="domain-form">
                <select class="form-select d-inline w-8" name="domain" id="domain-dropdown" required disabled>
                    <option value="">Pilih Domain</option>
                    <option value="1">Domain 1</option>
                    <option value="2">Domain 2</option>
                    <option value="3">Domain 3</option>
                </select>
            </form>
            <button id="refresh-button" class=" btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                </svg>Refresh</button>
            <button id="process-button" class="btn btn-success">
                Proses
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped" id="transaction-table">
                <thead>
                <tr>
                    <th>Nama Kota</th>
                    <th>No. Indikator</th>
                    <th>Goal</th>
                    <th>Tahun 2019</th>
                    <th>Tahun 2020</th>
                    <th>Growth Rate</th>
                    <th class="w-8">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="7">Silakan pilih provinsi dan kota untuk melihat data.</td>
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

        let groupedData = {};
        data.forEach(function(transaction) {
            let key = transaction.city_name + '-' + transaction.indicator_id;
            if (!groupedData[key]) {
                groupedData[key] = {
                    city_name: transaction.city_name,
                    indicator_id: transaction.indicator_id,
                    goal: transaction.goal,
                    year_2019: null,
                    year_2020: null,
                    growth_rate: null, // Initialize growth rate
                    id: transaction.id // Assuming you have an id field for actions
                };
            }
            if (transaction.year === '2019') {
                groupedData[key].year_2019 = transaction.value;
            } else if (transaction.year === '2020') {
                groupedData[key].year_2020 = transaction.value;
            }
            groupedData[key].growth_rate = transaction.growth_rate; // Get growth rate
        });

        Object.values(groupedData).forEach(function(transaction) {
            let row = tableBody.insertRow();
            row.insertCell(0).textContent = transaction.city_name;
            row.insertCell(1).textContent = transaction.indicator_id;
            row.insertCell(2).textContent = transaction.goal;
            row.insertCell(3).textContent = transaction.year_2019 !== null ? transaction.year_2019 : '-';
            row.insertCell(4).textContent = transaction.year_2020 !== null ? transaction.year_2020 : '-';
            row.insertCell(5).textContent = transaction.growth_rate !== null ? transaction.growth_rate : '-'; // Display growth rate

            let actionCell = row.insertCell(6); // Adjust the index for actions
            actionCell.innerHTML = `
                <a href="${baseUrl}edit/${transaction.id}" class="btn btn-sm">Edit</a>
                <form action="${baseUrl}delete/${transaction.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="d-inline-block">
                    <button type="submit" class="btn btn-sm">Hapus</button>
                </form>
            `;
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
            .then(data => {
                populateDropdown(document.getElementById('kota-dropdown'), data);
                document.getElementById('domain-dropdown').disabled = true; // Disable domain dropdown until city is selected
            })
            .catch(error => console.error('Error fetching city data:', error));
        } else {
            document.getElementById('kota-dropdown').innerHTML = '<option value="">Pilih Kota</option>';
            document.getElementById('domain-dropdown').innerHTML = '<option value="">Pilih Domain</option>';
            document.getElementById('domain-dropdown').disabled = true;
        }
    });

    document.getElementById('kota-dropdown').addEventListener('change', function() {
        const cityCode = this.value;

        if (cityCode) {
            document.getElementById('domain-dropdown').disabled = false; // Enable domain dropdown
            fetch(`${baseUrl}getTransactionsByCity`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ cityCode: cityCode })
            })
            .then(response => response.json())
            .then(data => {
                localStorage.setItem('allTransactions', JSON.stringify(data));
                renderTable(data);
            })
            .catch(error => console.error('Error fetching transaction data:', error));
        } else {
            document.getElementById('domain-dropdown').disabled = true; // Disable if no city is selected
        }
    });

    document.getElementById('domain-dropdown').addEventListener('change', function() {
        const domain = this.value;
        const allTransactions = JSON.parse(localStorage.getItem('allTransactions')) || [];
        const filteredTransactions = domain ? 
            allTransactions.filter(transaction => transaction.domain == domain) : 
            allTransactions;

        renderTable(filteredTransactions); // Use renderTable directly
    });

    document.getElementById('refresh-button').addEventListener('click', function() {
        // Reset dropdowns
        document.getElementById('provinsi-dropdown').selectedIndex = 0;
        document.getElementById('kota-dropdown').innerHTML = '<option value="">Pilih Kota</option>';
        document.getElementById('domain-dropdown').innerHTML = '<option value="">Pilih Domain</option>';
        document.getElementById('domain-dropdown').disabled = true;

        // Reset table
        const tableBody = document.getElementById('transaction-table').querySelector('tbody');
        tableBody.innerHTML = '<tr><td colspan="6">Silakan pilih provinsi dan kota untuk melihat data.</td></tr>';

        // Clear local storage
        localStorage.removeItem('allTransactions');
    });

    document.getElementById('process-button').addEventListener('click', function() {
        const allTransactions = JSON.parse(localStorage.getItem('allTransactions')) || [];

        // Kirim data ke server untuk diproses
        fetch(`${baseUrl}processTransactions`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ transactions: allTransactions })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Data berhasil diproses!');
                renderTable(data.transactions); // Tampilkan data yang sudah diproses
            } else {
                alert('Gagal memproses data.');
            }
        })
        .catch(error => console.error('Error processing transaction data:', error));
    });

</script>

<?= $this->endSection() ?>