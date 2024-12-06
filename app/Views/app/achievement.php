<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Peringkat
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <!-- Judul -->
    <h2 class="text-center mb-4">Peringkat Kabupaten/Kota</h2>

    <!-- Filter Data -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="m-0">Filter Data</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="search-kabupaten" class="form-label">Cari Kabupaten/Kota</label>
                    <input type="text" class="form-control" id="search-kabupaten" placeholder="Cari kabupaten/kota anda">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="region-dropdown" class="form-label">Wilayah Administratif</label>
                    <select class="form-select" id="region-dropdown">
                        <option value="" selected>Wilayah Administratif</option>
                        <option value="1">Kabupaten</option>
                        <option value="2">Kota</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="year-dropdown" class="form-label">Tahun</label>
                    <select class="form-select" id="year-dropdown">
                        <option value="" selected>Tahun</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Peringkat</th>
                            <th>Kabupaten/Kota</th>
                            <th>Wilayah</th>
                            <th>Tahun</th>
                            <th>Skor</th>
                            <th>Rating</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <?php $rank = 1; ?>
                        <?php foreach ($achievement as $achievements): ?>
                        <tr data-region="<?= $achievements['region'] ?>" data-year="<?= $achievements['year'] ?>">
                            <td class="text-center"><?= $rank++ ?></td>
                            <td class="text-center"><?= $achievements['city_name'] ?></td>
                            <td class="text-center"><?= $achievements['region'] == 1 ? 'Kabupaten' : 'Kota' ?></td>
                            <td class="text-center"><?= $achievements['year'] ?></td>
                            <td class="text-center <?= $achievements['champion_grade'] >= 80 ? 'text-success fw-bold' : ($achievements['champion_grade'] >= 50 ? 'text-warning' : 'text-danger') ?>">
                                <?= $achievements['champion_grade'] ?>
                            </td>
                            <td class="text-center"><?= $achievements['rating'] ?></td>
                            <td class="text-center">
                                <a href="<?= site_url('/app/grading/detail/' . urlencode($achievements['city_name'])) ?>" 
                                class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </div>
</div>

<script>
    const rowsPerPage = 10;
    const tableBody = document.getElementById('table-body');
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('search-kabupaten');
    const regionDropdown = document.getElementById('region-dropdown');
    const yearDropdown = document.getElementById('year-dropdown');
    let currentPage = 1;
    const maxPagesToShow = 5;

    function filterRows() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedRegion = regionDropdown.value;
        const selectedYear = yearDropdown.value;

        const rows = document.querySelectorAll('#table-body tr');
        rows.forEach(row => {
            const cityName = row.cells[1].textContent.toLowerCase();
            const region = row.getAttribute('data-region');
            const year = row.getAttribute('data-year');

            const matchesSearch = cityName.includes(searchTerm);
            const matchesRegion = selectedRegion === '' || selectedRegion === region;
            const matchesYear = selectedYear === '' || selectedYear === year;

            row.style.display = matchesSearch && matchesRegion && matchesYear ? '' : 'none';
        });

        initPagination();
    }

    function initPagination() {
        const rows = Array.from(document.querySelectorAll('#table-body tr')).filter(row => row.style.display !== 'none');
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

        if (totalRows > 0) {
            showPage(1);
        } else {
            pagination.innerHTML = '';
        }
    }

    // Event Listeners
    searchInput.addEventListener('input', filterRows);
    regionDropdown.addEventListener('change', filterRows);
    yearDropdown.addEventListener('change', filterRows);

    // Initialize Pagination and Filter
    initPagination();
</script>

<?= $this->endSection() ?>
