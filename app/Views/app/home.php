<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Home Page
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Welcome to My Website</h2>
<p>This is the home page.</p>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h3 class="card-title">Social referrals</h3>
                    <div class="ms-auto">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-secondary" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item active" href="#">Last 7 days</a>
                                <a class="dropdown-item" href="#">Last 30 days</a>
                                <a class="dropdown-item" href="#">Last 3 months</a>
                            </div>
                        </div>
                    </div>
                </div>
            <div id="chart-social-referrals" style="min-height: 288px;"></div>
        </div>
    </div>
</div>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            chart: {
                type: 'line',
                height: 288
            },
            series: [{
                name: 'Facebook',
                data: [30, 40, 35, 50, 49, 60, 70, 91]
            }, {
                name: 'Twitter',
                data: [20, 30, 40, 80, 20, 80, 90, 100]
            }, {
                name: 'Dribbble',
                data: [10, 20, 30, 40, 50, 60, 70, 80]
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug']
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart-social-referrals"), options);
        chart.render();
        });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    
<?= $this->endSection() ?>