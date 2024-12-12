<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Kabupaten / Kota
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Daftar Kabupaten / Kota</h2>

    <div class="row mb-4">
        <div class="col-md-6 offset-md-3 mb-3">
            <div class="input-group">
                <!-- SVG Icon as a separate element -->
                <span class="input-group-text bg-primary text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M21 21l-6 -6"></path>
                    </svg>
                </span>
                <!-- Input Field -->
                <input type="text" class="form-control" id="search-kabupaten" placeholder="Cari kabupaten/kota anda">
            </div>
        </div>
    </div>


    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Kabupaten / Kota</h5>
            <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= site_url('/app/city/form') ?>" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nama Kab / Kota</th>
                            <th>Provinsi</th>
                            <th>Kode BPS</th>
                            <th>Kode Kemendagri</th>
                            <?php if (session()->get('role') === 'admin'): ?>
                                <th class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <?php if (empty($data_city)): ?>
                            <tr>
                                <td colspan="<?= (session()->get('role') === 'admin') ? '6' : '5' ?>" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data_city as $city): ?>
                                <tr>
                                    <td class="text-center"><?= esc($city['id']) ?></td>
                                    <td><?= esc($city['city_name']) ?></td>
                                    <td class="text-center"><?= esc($city['province_name']) ?></td>
                                    <td class="text-center"><?= esc($city['bps_code']) ?></td>
                                    <td class="text-center"><?= esc($city['kemendagri_code']) ?></td>
                                    <?php if (session()->get('role') === 'admin'): ?>
                                        <td class="text-center">
                                            <a href="<?= site_url('/app/city/edit/' . $city['id']) ?>" 
                                               class="btn btn-sm btn-warning">
                                               <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <form action="<?= site_url('/app/city/delete/' . $city['id']) ?>" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" 
                                                  class="d-inline-block">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <nav style="margin-top: 30px;">
                    <ul class="pagination justify-content-center" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
    const rowsPerPage = 10;
    const tableBody = document.getElementById('table-body');
    const pagination = document.getElementById('pagination');
    let currentPage = 1;
    const maxPagesToShow = 5;

    function initPagination() {
        const rows = document.querySelectorAll('#table-body tr');
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        function renderPagination() {
            pagination.innerHTML = `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage - 1}">&laquo; Prev</a>
                </li>
            `;
            const startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
            const endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);

            for (let i = startPage; i <= endPage; i++) {
                pagination.innerHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            }

            pagination.innerHTML += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage + 1}">Next &raquo;</a>
                </li>
            `;
        }

        function showPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = index >= start && index < end ? '' : 'none';
            });

            currentPage = page;
            renderPagination();
        }

        pagination.addEventListener('click', (e) => {
            e.preventDefault();
            const page = parseInt(e.target.getAttribute('data-page'));
            if (page) showPage(page);
        });

        showPage(1);
    }

    initPagination();

    // Event listener for search input
    document.getElementById('search-kabupaten').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#table-body tr');

        rows.forEach(row => {
            const cityName = row.cells[1].textContent.toLowerCase();
            if (cityName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<?= $this->endSection() ?>
