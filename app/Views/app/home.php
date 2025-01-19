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
                                 style="max-width: 130px;">
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
        <!-- SDG Performance Charts -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">SDG Performance by City</h5>
                    <!-- Single Dropdown Filter -->
                    <select class="form-select" style="max-width: 150px;" id="region-dropdown">
                        <option value="" selected>Region</option>
                        <option value="Kabupaten">Regencies</option>
                        <option value="Kota">Cities</option>
                    </select>
                </div>
                <div class="card-body">
                   <div class="row">
                        <!-- Top 10 Cities by SDG Performance -->
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm border-0 rounded">
                                <!-- <div class="card-header bg-success text-white">
                                    <h5 class="card-title m-0">Top 10 Cities by SDG Performance</h5>
                                </div> -->
                                <div class="card-body p-3">
                                    <canvas id="cityPerformanceChart" height="220"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- City SDG Performance Distribution -->
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm border-0 rounded">
                                <!-- <div class="card-header bg-success text-white">
                                    <h5 class="card-title m-0">City SDG Performance Distribution</h5>
                                </div> -->
                                <div class="card-body p-3">
                                    <canvas id="performanceDistributionChart" height="220"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- SDG Performance by Goal Chart -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title m-0">SDG Performance by Goal</h5>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height: 400px;">
                    <!-- Centering the canvas using flexbox -->
                    <canvas id="sdgGoalsChart" style="max-width: 100%; max-height: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const cityNames = <?= json_encode($cityNames ?? []) ?>;
    const ratings = <?= json_encode($ratings ?? []) ?>;
    const goalLabels = <?= json_encode(array_keys($goalRatings ?? [])) ?>;
    const goalRatings = <?= json_encode(array_values($goalRatings ?? [])) ?>;

    document.getElementById('region-dropdown').addEventListener('change', function() {
        applyRegionFilter();
    });

    function applyRegionFilter() {
        const selectedRegion = document.getElementById('region-dropdown').value;

        if (!selectedRegion) return;

        const url = new URL(window.location.href);
        url.searchParams.set('region', selectedRegion);

        window.location.href = url.toString();
    }

    // City Performance Chart (Bar Chart)
    new Chart(document.getElementById('cityPerformanceChart'), {
        type: 'bar',
        data: {
            labels: cityNames || ['No Data'],
            datasets: [{
                label: 'City Performance Rating',
                data: ratings || [0],
                backgroundColor: ratings.map(rating => {
                    if (rating >= 80) return '#4CAF50'; // Light Green
                    if (rating >= 70) return '#8BC34A'; // Light Blue
                    if (rating >= 60) return '#FFEB3B'; // Orange
                    if (rating >= 50) return '#FFC107'; // Yellow
                    return '#F44336'; // Red
                }),
                borderColor: '#fff', // Border color for bars
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Allows resizing based on the container
            scales: {
                y: { 
                    beginAtZero: true, 
                    ticks: { 
                        precision: 0,
                        stepSize: 10 
                    } 
                },
                x: {
                    title: {
                        display: true,
                        text: 'Cities',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `Rating: ${tooltipItem.raw}%`;
                        }
                    }
                }
            }
        }
    });

    // Performance Distribution Chart (Pie Chart)
    var ctx2 = document.getElementById('performanceDistributionChart').getContext('2d');
    var performanceDistributionChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Revolutioner', 'Innovator', 'Advocator', 'Encourager', 'Exciter'],
            datasets: [{
                data: [
                    ratings.filter(r => r >= 80 && r < 100).length, // 80-100
                    ratings.filter(r => r >= 70 && r < 80).length, // 70-79
                    ratings.filter(r => r >= 60 && r < 70).length, // 60-69
                    ratings.filter(r => r >= 50 && r < 60).length, // 50-59
                    ratings.filter(r => r < 50).length // <50
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
                    position: 'right', // Position of the legend
                    labels: {
                        boxWidth: 10, // Smaller legend box width
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let label = tooltipItem.label;
                            let value = tooltipItem.raw;
                            return `${label}: ${value} Cities`;
                        }
                    }
                }
            }
        }
    });



    new Chart(document.getElementById('sdgGoalsChart'), {
        type: 'radar',
        data: {
            labels: goalLabels || ['No Data'],
            datasets: [{ label: 'Average Performance (%)', data: goalRatings || [0], backgroundColor: 'rgba(75, 192, 192, 0.2)', borderColor: '#36A2EB' }]
        },
        options: { responsive: true }
    });
</script>

<?= $this->endSection() ?>
