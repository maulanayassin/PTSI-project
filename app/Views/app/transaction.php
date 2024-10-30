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
            })
            .catch(error => console.error('Error fetching city data:', error));
        } else {
            document.getElementById('kota-dropdown').innerHTML = '<option value="">Pilih Kota</option>';
        }
    });

    document.getElementById('kota-dropdown').addEventListener('change', function() {
        let cityCode = this.value;

        if (cityCode) {
            document.getElementById('domain-dropdown').disabled = false;
            fetch('<?= site_url('/app/transaction/getTransactionsByCity') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                },
                body: JSON.stringify({ cityCode: cityCode })
            })
            .then(response => response.json())
            .then(data => {
                let tableBody = document.getElementById('transaction-table').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = '';
                localStorage.setItem('allTransactions', JSON.stringify(data));

                if (data.length === 0) {
                    let row = tableBody.insertRow();
                    row.insertCell(0).colSpan = 6;
                    row.innerHTML = 'Tidak ada data untuk kota yang dipilih.';
                } else {
                    data.forEach(function(transaction) {
                        let row = tableBody.insertRow();
                        row.insertCell(0).textContent = transaction.city_name;
                        row.insertCell(1).textContent = transaction.indicator_id;
                        row.insertCell(2).textContent = transaction.goal;
                        row.insertCell(3).textContent = transaction.year_2019;
                        row.insertCell(4).textContent = transaction.year_2020;

                        let actionCell = row.insertCell(5);
                        actionCell.innerHTML = `
                            <a href="<?= site_url('/app/transaction/edit/') ?>${transaction.id}" class="btn btn-sm">Edit</a>
                            <form action="<?= site_url('/app/transaction/delete/') ?>${transaction.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="d-inline-block">
                                <button type="submit" class="btn btn-sm">Hapus</button>
                            </form>
                        `;
                    });
                }
            })
            .catch(error => console.error('Error fetching transaction data:', error));
        } else {
            // Disable dropdown "Domain" jika tidak ada kota yang dipilih
            document.getElementById('domain-dropdown').disabled = true;
        }
    });

    document.getElementById('domain-dropdown').addEventListener('change', function() {
        let domain = this.value;
        let allTransactions = JSON.parse(localStorage.getItem('allTransactions')) || [];

        let tableBody = document.getElementById('transaction-table').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = ''; 

        if (domain === "") {
            allTransactions.forEach(function(transaction) {
                let row = tableBody.insertRow();
                row.insertCell(0).textContent = transaction.city_name;
                row.insertCell(1).textContent = transaction.indicator_id;
                row.insertCell(2).textContent = transaction.goal;
                row.insertCell(3).textContent = transaction.year_2019;
                row.insertCell(4).textContent = transaction.year_2020;

                let actionCell = row.insertCell(5);
                actionCell.innerHTML = `
                    <a href="<?= site_url('/app/transaction/edit/') ?>${transaction.id}" class="btn btn-sm">Edit</a>
                    <form action="<?= site_url('/app/transaction/delete/') ?>${transaction.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="d-inline-block">
                        <button type="submit" class="btn btn-sm">Hapus</button>
                    </form>
                `;
            });
        } else {
            let filteredTransactions = allTransactions.filter(transaction => transaction.domain == domain);

            if (filteredTransactions.length === 0) {
                let row = tableBody.insertRow();
                row.insertCell(0).colSpan = 6;
                row.innerHTML = 'Tidak ada data untuk domain yang dipilih.';
            } else {
                filteredTransactions.forEach(function(transaction) {
                    let row = tableBody.insertRow();
                    row.insertCell(0).textContent = transaction.city_name;
                    row.insertCell(1).textContent = transaction.indicator_id;
                    row.insertCell(2).textContent = transaction.goal;
                    row.insertCell(3).textContent = transaction.year_2019;
                    row.insertCell(4).textContent = transaction.year_2020;

                    let actionCell = row.insertCell(5);
                    actionCell.innerHTML = `
                        <a href="<?= site_url('/app/transaction/edit/') ?>${transaction.id}" class="btn btn-sm">Edit</a>
                        <form action="<?= site_url('/app/transaction/delete/') ?>${transaction.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="d-inline-block">
                            <button type="submit" class="btn btn-sm">Hapus</button>
                        </form>
                    `;
                });
            }
        }
    });

    // Fungsi untuk menyimpan data di cookies
    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
        console.log("Setting cookie:", document.cookie); // Untuk verifikasi
    }


    // Fungsi untuk mengambil nilai dari cookies
    function getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    // Menyimpan pilihan provinsi, kota, dan domain ke cookies saat ada perubahan
    document.getElementById('provinsi-dropdown').addEventListener('change', function() {
        setCookie('selectedProvince', this.value, 7);
    });

    document.getElementById('kota-dropdown').addEventListener('change', function() {
        setCookie('selectedCity', this.value, 7);
    });

    document.getElementById('domain-dropdown').addEventListener('change', function() {
        console.log("Domain selected:", this.value); // Untuk memastikan nilai domain terdeteksi
        setCookie('selectedDomain', this.value, 7);
        console.log("Cookie selectedDomain set to:", getCookie('selectedDomain')); // Verifikasi apakah cookie disimpan
    });


    // Fungsi untuk menetapkan pilihan sesuai dengan data di cookies
    window.onload = async function() {
        const selectedProvince = getCookie('selectedProvince');
        const selectedCity = getCookie('selectedCity');
        const selectedDomain = getCookie('selectedDomain');

        try {
            // Langkah 1: Set Provinsi dan muat data kota
            if (selectedProvince) {
                document.getElementById('provinsi-dropdown').value = selectedProvince;
                await new Promise(resolve => {
                    document.getElementById('provinsi-dropdown').addEventListener('change', resolve, { once: true });
                    document.getElementById('provinsi-dropdown').dispatchEvent(new Event('change'));
                });
            }

            // Langkah 2: Set Kota (pastikan data kota sudah dimuat)
            if (selectedCity) {
                await new Promise(resolve => setTimeout(resolve, 100)); // Tunggu data kota selesai dimuat
                document.getElementById('kota-dropdown').value = selectedCity;
                document.getElementById('kota-dropdown').dispatchEvent(new Event('change'));
            }

            // Langkah 3: Set Domain
            if (selectedDomain) {
                document.getElementById('domain-dropdown').value = selectedDomain;
                document.getElementById('domain-dropdown').dispatchEvent(new Event('change'));
            }
        } catch (error) {
            console.error('Error saat memuat pengaturan tersimpan:', error);
        }
    };

    // Fungsi untuk menghapus cookies
    function deleteCookie(name) {
        document.cookie = name + '=; Max-Age=-99999999;';
    }

    // Bersihkan cookies saat tombol 'Simpan Perubahan' diklik
    document.querySelector('form').addEventListener('submit', function() {
        deleteCookie('selectedProvince');
        deleteCookie('selectedCity');
        deleteCookie('selectedDomain');
    });

</script>

<?= $this->endSection() ?>