<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Daftar Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">User List</h2>

    <!-- Search Box -->
    <div class="row mb-4">
        <div class="col-md-6 offset-md-3 mb-3">
            <div class="input-group">
                <!-- SVG Icon untuk Pencarian -->
                <span class="input-group-text bg-primary text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M21 21l-6 -6"></path>
                    </svg>
                </span>
                <!-- Input untuk Pencarian -->
                <input type="text" class="form-control" id="searchUser" placeholder="Search users...">
            </div>
        </div>
    </div>

    <!-- Card untuk Daftar Pengguna -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">User Data</h5>
            <!-- Tombol Tambah Pengguna Selalu Ada -->
            <a href="<?= site_url('/admin/users/create') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Create User
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">No user data</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="text-center"><?= esc($user['id']) ?></td>
                                    <td><?= esc($user['username']) ?></td>
                                    <td><?= esc($user['email']) ?></td>
                                    <td class="text-center"><?= esc($user['role']) ?></td>
                                    <td class="text-center">
                                        <!-- Tombol Edit -->
                                        <a href="<?= site_url('/admin/users/edit/' . $user['id']) ?>" 
                                           class="btn btn-sm btn-warning">
                                           <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <form action="<?= site_url('/admin/users/delete/' . $user['id']) ?>" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');" 
                                              class="d-inline-block">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
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

    // Pagination Logic
    function initPagination() {
        const rows = document.querySelectorAll('#table-body tr');
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        function renderPagination() {
            pagination.innerHTML = `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage - 1}">Prev</a>
                </li>
            `;
            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            }
            pagination.innerHTML += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
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

    // Search Logic
    document.getElementById('searchUser').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#table-body tr');
        rows.forEach(row => {
            const username = row.cells[1].textContent.toLowerCase();
            row.style.display = username.includes(searchValue) ? '' : 'none';
        });
    });
</script>

<?= $this->endSection() ?>
