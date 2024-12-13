<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
SDG Data Monitoring
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xl">
    <!-- Page Title -->
    <h2 class="page-title text-center mb-4 text-primary">Sustainable Development Goals (SDG) City Rankings</h2>
    <p class="text-center mb-5 text-muted">Monitor SDG performance across cities and visualize progress towards achieving global sustainability goals.</p>

    <!-- Informasi SDGs -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-header bg-light text-center">
                    <h5 class="card-title text-primary m-0">What are Sustainable Development Goals (SDGs)?</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <img src="dist/img/download.jpeg" 
                                 alt="SDG Logo" 
                                 class="img-fluid mb-3" 
                                 style="max-width: 150px;">
                        </div>
                        <div class="col-md-9">
                            <p class="text-muted mb-3" style="text-align: justify;">
                                The Sustainable Development Goals (SDGs) are a universal call to end poverty, protect the planet, and ensure peace and prosperity for all by 2030. Adopted by all Member States of the United Nations, the SDGs consist of 17 interrelated goals, each addressing a critical global challenge.
                            </p>
                            <a href="https://sdgs.un.org/goals" target="_blank" class="btn btn-outline-primary btn-sm">
                                Learn More About SDGs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visualisasi Utama -->
    <div class="row g-4 mb-4">
        <!-- Top 10 Cities by SDG Performance -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title m-0">Top 10 Cities by SDG Performance</h5>
                    </div>
                    <!-- Region Filter for Top 10 Cities -->
                    <select class="form-select" style="max-width: 150px;" id="region-dropdown-top10" name="region-dropdown">
                        <option value="" selected>Wilayah</option>
                        <option value="Kabupaten">Kabupaten</option>
                        <option value="Kota">Kota</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="cityPerformanceChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- City SDG Performance Distribution -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded h-100">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title m-0">City SDG Performance Distribution</h5>
                    </div>
                    <!-- Region Filter for Performance Distribution -->
                    <select class="form-select" style="max-width: 150px;" id="region-dropdown-distribution" name="region-dropdown">
                        <option value="" selected>Wilayah</option>
                        <option value="Kabupaten">Kabupaten</option>
                        <option value="Kota">Kota</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="performanceDistributionChart" height="300"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- SDG Performance by Goal Chart -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title">SDG Performance by Goal</h5>
                    <!-- <p class="card-subtitle text-white-50">A detailed radar chart showcasing SDG performance across all goals.</p> -->
                </div>
                <div style="width: 100%; height: 400px;">
                    <canvas id="sdgGoalsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<script>
    // Event Listener for Region Filters
    document.getElementById('region-dropdown-top10').addEventListener('change', function() {
        applyRegionFilter('top10');
    });

    document.getElementById('region-dropdown-distribution').addEventListener('change', function() {
        applyRegionFilter('distribution');
    });

    function applyRegionFilter(chartType) {
        const selectedRegionTop10 = document.getElementById('region-dropdown-top10').value;
        const selectedRegionDistribution = document.getElementById('region-dropdown-distribution').value;

        let selectedRegion = chartType === 'top10' ? selectedRegionTop10 : selectedRegionDistribution;

        const url = new URL(window.location.href);
        url.searchParams.set('region', selectedRegion); // Update the region parameter in the URL

        window.location.href = url.toString(); // Reload the page with the new region filter
    }

    // Top 5 Cities by SDG Performance (Bar Chart)
    var ctx1 = document.getElementById('cityPerformanceChart').getContext('2d');
    var cityPerformanceChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?= json_encode($cityNames) ?>, // Nama kota
            datasets: [{
                label: 'City Performance Rating',
                data: <?= json_encode($ratings) ?>,
                backgroundColor: ['#4CAF50', '#8BC34A', '#FFEB3B', '#FFC107', '#F44336'],
                borderColor: '#333',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Performance Score'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'City Names'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true
                },
                title: {
                    display: true,
                    text: 'City Performance Chart'
                }
            }
        }
    });

    // Performance Distribution (Pie Chart)
    var ctx2 = document.getElementById('performanceDistributionChart').getContext('2d');
    var performanceDistributionChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Revolutioner', 'Innovator', 'Advocator', 'Encourager', 'Exciter'],
            datasets: [{
                data: [
                    <?= count(array_filter($ratings, function($rating) { return $rating >= 80 && $rating < 100; })) ?>, 
                    <?= count(array_filter($ratings, function($rating) { return $rating >= 70 && $rating < 80; })) ?>,
                    <?= count(array_filter($ratings, function($rating) { return $rating >= 60 && $rating < 70; })) ?>,
                    <?= count(array_filter($ratings, function($rating) { return $rating >= 50 && $rating < 60; })) ?>,
                    <?= count(array_filter($ratings, function($rating) { return $rating < 50; })) ?>
                ],
                backgroundColor: ['#4CAF50', '#8BC34A', '#FFEB3B', '#FFC107', '#F44336'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 10,
                    }
                }
            }
        }
    });

    // SDG Performance by Goal (Radar Chart)
    var ctx3 = document.getElementById('sdgGoalsChart').getContext('2d');
    var sdgGoalsChart = new Chart(ctx3, {
        type: 'radar',
        data: {
            labels: <?= json_encode($goalLabels) ?>,
            datasets: [{
                label: 'Average Performance (%)',
                data: <?= json_encode($goalRatings) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: '#36A2EB',
                pointBackgroundColor: '#36A2EB',
                pointHoverBackgroundColor: '#FF5733',
                pointRadius: 4,
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10,
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>
