<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Detail SDG Data - <?= $selectedCity ?? 'Kota/Kabupaten' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <!-- Judul -->
    <h2 class="text-center mb-4 text-primary fw-bold">Detail SDG Data - <?= $selectedCity ?? 'Kota/Kabupaten' ?></h2>

    <!-- SDG Index Overview -->
    <div class="row">
        <!-- SDG Index Rank -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <h2 class="text-muted fw-bold">PERINGKAT KOTA</h2>
                    <div class="text-primary display-5 fw-bold"><?= $query_rank ?? 0 ?></div>
                    <span class="text-muted fs-6">dari <?= $sdgDataCount ?? 0 ?> Kota</span>
                </div>
            </div>
        </div>

        <!-- SDG Index Score -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <h2 class="text-muted fw-bold">INDEKS SKOR SDG</h2>
                    <div class="position-relative d-inline-block">
                        <!-- SVG Progress Circle -->
                        <svg width="120" height="120" class="mb-2">
                            <circle cx="60" cy="60" r="50" fill="none" stroke="#f0f0f0" stroke-width="10"></circle>
                            <circle cx="60" cy="60" r="50" fill="none" stroke="#007bff" stroke-width="10" 
                                    stroke-dasharray="314.159" 
                                    stroke-dashoffset="<?= (100 - $query_score) * 3.14159 ?>" 
                                    transform="rotate(-90 60 60)"></circle>
                        </svg>
                        <!-- Score in the Center -->
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <h3 class="fw-bold text-primary m-0"><?= $query_score ?? 0 ?></h3>
                            <small class="text-muted">dari 100</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 animated-card">
                <div class="row align-items-center p-3">
                    <!-- Bagian Nama Kota & Provinsi -->
                    <div class="col-md-8 text-justify">
                        <h4 class="text-primary mb-2 city-title">
                            <strong><?= $selectedCity ?? 'Kota/Kabupaten' ?></strong> merupakan salah satu kota yang berada di peringkat 
                            <span class="text-success"><?= $queryRankByProvince ?? 0 ?></span>
                            di provinsi <strong><?= $selectedProvince ?? 'provinsi' ?></strong>
                        </h4>
                    </div>
                    <!-- Bagian Logo Provinsi -->
                    <div class="col-md-4 text-center">
                        <div class="logo-container">
                            <img src="<?= $provinceLogo ?>" alt="Logo <?= $selectedProvince ?>" class="img-logo img-fluid mb-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visualisasi dan Goal SDG yang Memerlukan Perbaikan Bersebelahan -->
    <div class="row">
        <!-- Visualisasi Chart -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="m-0">Visualisasi Goal Data SDG <?= $selectedCity ?? 'Kota/Kabupaten' ?></h5>
                </div>
                <div class="card-body text-center">
                    <div class="chart-container" style="position: relative; height: 350px; width: 100%; margin: auto;">
                        <canvas id="sdgChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Goal SDG yang Memerlukan Perbaikan -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-danger text-white text-center">
                    <h5 class="m-0">Goal SDG yang Memerlukan Perbaikan</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Berikut adalah goal SDG yang memiliki skor < 50 dan memerlukan perhatian khusus.
                    </p>
                    <ul class="text-danger">
                        <?php 
                        $poorGoals = array_filter($sdgData, function($data) {
                            return $data['score'] < 50;
                        });
                        
                        if (count($poorGoals) > 0): 
                            foreach ($poorGoals as $data): ?>
                                <li class="d-flex align-items-center mb-2">
                                    <img src="<?= getGoalImage($data['goal']) ?>" alt="Goal <?= $data['goal'] ?>" 
                                        class="img-thumbnail" style="max-height: 40px; margin-right: 10px;">
                                    Goal <?= $data['goal'] ?> dengan score  
                                    <?= $data['score'] ?> Perlu <?= getGoalDescription($data['goal']) ?>
                                </li>
                            <?php endforeach; 
                        else: ?>
                            <li>Tidak ada goal yang memerlukan perhatian ekstra.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div> <!-- End of Visualisasi + Perbaikan Row -->

    <!-- Tabel Data SDG -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="m-0">Data SDG Tabel Lengkap</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>Goal</th>
                                    <th>Keterangan Goal</th>
                                    <th>Skor</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sdgData as $data): ?>
                                <tr class="<?= is_null($data['score']) ? 'table-danger' : '' ?>">
                                    <td class="text-center"><?= $data['goal'] ?></td>
                                    <td><?= $data['goal_name'] ?></td>
                                    <td class="text-center"><?= $data['score'] ?? 'N/A' ?></td>
                                    <td class="text-center
                                        <?php 
                                        $rating = $data['rating'];
                                        if ($rating === 'N/A') {
                                            echo 'text-muted';
                                        } elseif ($rating === 'EXCITER') {
                                            echo 'text-danger';
                                        } elseif ($rating === 'ENCOURAGER') {
                                            echo 'text-warning';
                                        } elseif ($rating === 'ADVOCATOR') {
                                            echo 'text-info';
                                        } elseif ($rating === 'INNOVATOR') {
                                            echo 'text-primary';
                                        } elseif ($rating === 'REVOLUTIONER') {
                                            echo 'text-success fw-bold';
                                        }
                                        ?>">
                                        <?= $rating ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        function getGoalDescription($goal) {
            $descriptions = [
                1 => 'menghapus kemiskinan di segala bentuknya.',
                2 => 'mengakhiri kelaparan dan meningkatkan ketahanan pangan.',
                3 => 'mendukung kesehatan yang baik dan kesejahteraan.',
                4 => 'memastikan pendidikan berkualitas yang inklusif.',
                5 => 'mencapai kesetaraan gender dan pemberdayaan perempuan.',
                6 => 'menjamin akses terhadap air bersih dan sanitasi.',
                7 => 'meningkatkan akses energi bersih dan terjangkau.',
                8 => 'mendukung pekerjaan layak dan pertumbuhan ekonomi.',
                9 => 'meningkatkan infrastruktur, inovasi, dan industrialisasi.',
                10 => 'mengurangi ketimpangan di dalam dan antar negara.',
                11 => 'menciptakan kota dan komunitas berkelanjutan.',
                12 => 'meningkatkan pola konsumsi dan produksi yang bertanggung jawab.',
                13 => 'mengatasi perubahan iklim dan dampaknya.',
                14 => 'melindungi dan melestarikan ekosistem laut.',
                15 => 'melindungi ekosistem darat dan keanekaragaman hayati.',
                16 => 'mendukung perdamaian, keadilan, dan kelembagaan yang kuat.',
                17 => 'membangun kemitraan global untuk mencapai tujuan SDG.',
            ];
            return $descriptions[$goal] ?? 'Deskripsi tidak tersedia.';
        }
        function getGoalImage($goal) {
            $goalImages = [
                1 => base_url('dist/img/1.png'),
                2 => base_url('dist/img/2.png'),
                3 => base_url('dist/img/3.png'),
                4 => base_url('dist/img/4.png'),
                5 => base_url('dist/img/5.png'),
                6 => base_url('dist/img/6.png'),
                7 => base_url('dist/img/7.png'),
                8 => base_url('dist/img/8.png'),
                9 => base_url('dist/img/9.png'),
                10 => base_url('dist/img/10.png'),
                11 => base_url('dist/img/11.png'),
                12 => base_url('dist/img/12.png'),
                13 => base_url('dist/img/13.png'),
                14 => base_url('dist/img/14.png'),
                15 => base_url('dist/img/15.png'),
                16 => base_url('dist/img/16.png'),
                17 => base_url('dist/img/17.png'),
            ];
            return $goalImages[$goal] ?? base_url('public/assets/img/goals/default.png'); // Gambar default jika tidak cocok
        }
        ?>
        
    </div> <!-- End of Data SDG Table -->

</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ambil data dari PHP ke dalam JavaScript
    const sdgData = <?= json_encode($sdgData) ?>;

    // Proses data untuk visualisasi
    const labels = sdgData.map(data => `Goal ${data.goal}`);
    const scores = sdgData.map(data => data.score || 0);

    const ctx = document.getElementById('sdgChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(40, 167, 69, 0.8)');
    gradient.addColorStop(0.5, 'rgba(255, 193, 7, 0.8)');
    gradient.addColorStop(1, 'rgba(220, 53, 69, 0.8)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Skor SDG',
                data: scores,
                backgroundColor: gradient,
                borderColor: 'rgba(0, 0, 0, 0.1)',
                borderWidth: 1,
                hoverBackgroundColor: 'rgba(0, 123, 255, 0.9)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: (context) => `Skor: ${context.raw}`,
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Skor'
                    },
                },
                x: {
                    title: {
                        display: true,
                        text: 'Goal SDG'
                    }
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>
