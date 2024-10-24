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
            <a href="<?= site_url('/app/transaction/form') ?>" class="btn btn-pill">Tambah</a>
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
                    <th class="w-8">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="6">Silakan pilih provinsi dan kota untuk melihat data.</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('provinsi-dropdown').addEventListener('change', function() {
        let provinceCode = this.value;

        if (provinceCode) {
            fetch('<?= site_url('/app/indicator/getCities') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                },
                body: JSON.stringify({ provinceCode: provinceCode }) // Kirim kode provinsi ke backend
            })
            .then(response => response.json())
            .then(data => {
                let kotaDropdown = document.getElementById('kota-dropdown');
                kotaDropdown.innerHTML = '<option value="">Pilih Kota</option>'; // Reset dropdown kota
                data.forEach(function(city) {
                    let option = document.createElement('option');
                    option.value = city.kemendagri_code; // Menggunakan kemendagri_code untuk ID kota
                    option.text = city.city_name; // Tampilkan nama kota
                    kotaDropdown.appendChild(option); // Tambahkan opsi kota ke dropdown
                });
            })
            .catch(error => console.error('Error fetching city data:', error));
        } else {
            document.getElementById('kota-dropdown').innerHTML = '<option value="">Pilih Kota</option>'; // Reset jika provinsi kosong
        }
    });


    document.getElementById('kota-dropdown').addEventListener('change', function() {
        let cityCode = this.value;
        document.getElementById('city_id').value = cityCode;

        if (cityCode) {
            fetch('<?= site_url('/app/transaction/getTransactionsByCity') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                },
                body: JSON.stringify({ cityCode: cityCode }) // Menggunakan cityCode
            })
            .then(response => response.json())
            .then(data => {
                let tableBody = document.getElementById('transaction-table').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = ''; // Kosongkan tabel

                if (data.length === 0) {
                    let row = tableBody.insertRow();
                    row.insertCell(0).colSpan = 6;
                    row.innerHTML = 'Tidak ada data untuk kota yang dipilih.';
                } else {
                    data.forEach(function(transaction) {
                        let row = tableBody.insertRow();
                        row.insertCell(0).textContent = transaction.city_name; // Menggunakan nama kota dari transaksi
                        row.insertCell(1).textContent = transaction.indicator_id; // ID indikator
                        row.insertCell(2).textContent = transaction.goal; // Goal
                        row.insertCell(3).textContent = transaction.year_2019; // Tahun 2019
                        row.insertCell(4).textContent = transaction.year_2020; // Tahun 2020

                        let actionCell = row.insertCell(5);
                        actionCell.innerHTML = `
                            <a href="<?= site_url('/app/Transaction/edit/') ?>${transaction.id}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= site_url('/app/Transaction/delete/') ?>${transaction.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="d-inline-block">
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        `;
                    });
                }
            })
            .catch(error => console.error('Error fetching transaction data:', error));
        }
    });
</script>

<?= $this->endSection() ?>
