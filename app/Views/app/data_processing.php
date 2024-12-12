<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Data Processing
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Data Processing</h1>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Proses Data</h5>
        </div>
        <div class="card-body">
            <!-- Feedback Alert Section -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <p class="text-muted mb-4">Pilih domain yang ingin Anda proses dan klik tombol di bawah ini untuk memulai pemrosesan data ke dalam sistem.</p>
            <form action="<?= site_url('app/dataprocessing/processData') ?>" method="post">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="domains[]" value="domain_1" id="domain1">
                    <label class="form-check-label" for="domain1">Domain 1 - Mengupdate nilai berdasarkan laju pertumbuhan (growth rate)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="domains[]" value="domain_2" id="domain2">
                    <label class="form-check-label" for="domain2">Domain 2 - Mengupdate nilai dengan validasi verifikasi (TRUE atau FALSE)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="domains[]" value="domain_3A" id="domain3A">
                    <label class="form-check-label" for="domain3A">Domain 3A - Perhitungan berbasis nilai fix dan validasi</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="domains[]" value="domain_3B" id="domain3B">
                    <label class="form-check-label" for="domain3B">Domain 3B - Perhitungan berbasis nilai fix dan grouping</label>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-success btn-lg">Mulai Proses Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Informasi untuk Pengguna -->
    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5>Informasi Proses</h5>
        </div>
        <div class="card-body">
            <p>
                Pemrosesan ini akan memperbarui data dalam berbagai domain yang meliputi Domain 1, Domain 2, Domain 3A, dan Domain 3B.
                Selain itu, sistem juga akan memperbarui kalkulasi dalam achievement dan grading setelah pemrosesan selesai.
            </p>
            <ul>
                <li><strong>Domain 1:</strong> Mengupdate nilai berdasarkan laju pertumbuhan (growth rate).</li>
                <li><strong>Domain 2:</strong> Mengupdate nilai dengan mempertahankan validasi verifikasi (TRUE atau FALSE).</li>
                <li><strong>Domain 3A dan 3B:</strong> Menggunakan perhitungan berbasis nilai fix dan data grouping.</li>
                <li>Kalkulasi <strong>Achievement</strong> dan <strong>Grading</strong> akan dilakukan setelah pemrosesan selesai.</li>
            </ul>
            <p class="text-muted">Proses ini memerlukan koneksi database yang aktif dan cukup waktu tergantung pada ukuran datanya.</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
