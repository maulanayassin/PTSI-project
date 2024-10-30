<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
SDG Data Monitoring
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2 class="page-title">Sustainable Development Goals (SDG) Monitoring</h2>
<p>Welcome to the SDG data monitoring dashboard. Here, you can track and analyze key metrics across different goals and regions.</p>

<div class="page-wrapper">
    <div class="container-xl">
        <!-- Overview Cards -->
        <!-- <div class="row row-cards">
            <div class="col-md-3 col-sm-6">
                <div class="card card-metric">
                    <div class="card-body">
                        <h3 class="card-title">Goal 1</h3>
                        <div class="metric-value">No Poverty</div>
                        <div class="metric-status">Status: <span class="status-green">On Track</span></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-metric">
                    <div class="card-body">
                        <h3 class="card-title">Goal 2</h3>
                        <div class="metric-value">Zero Hunger</div>
                        <div class="metric-status">Status: <span class="status-yellow">Needs Improvement</span></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-metric">
                    <div class="card-body">
                        <h3 class="card-title">Goal 3</h3>
                        <div class="metric-value">Good Health and Well-Being</div>
                        <div class="metric-status">Status: <span class="status-red">Off Track</span></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-metric">
                    <div class="card-body">
                        <h3 class="card-title">Goal 4</h3>
                        <div class="metric-value">Quality Education</div>
                        <div class="metric-status">Status: <span class="status-green">On Track</span></div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- SDG Visualization Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-visualization">
                    <div class="card-header">
                        <h3 class="card-title">SDG Goal Progress - Visualizations</h3>
                    </div>
                    <div class="card-body">
                        <!-- Embed iframe visualizations or charts here -->
                        <iframe width="100%" height="600" src="https://v3.polymersearch.com/b/6711c3bdae6d5b0009630c98?m=embed&b=e81c64c9-0f5a-4c0f-b606-de563295ed5d&f=1&c=1" style="border:none;"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Tables Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-data-table">
                    <div class="card-header">
                        <h3 class="card-title">Detailed SDG Metrics</h3>
                    </div>
                    <div class="card-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Goal</th>
                                    <th>Progress (%)</th>
                                    <th>Region</th>
                                    <th>Last Update</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>No Poverty</td>
                                    <td>75%</td>
                                    <td>Asia</td>
                                    <td>2023-09-15</td>
                                    <td><button class="btn btn-sm btn-primary">View Details</button></td>
                                </tr>
                                <tr>
                                    <td>Zero Hunger</td>
                                    <td>60%</td>
                                    <td>Africa</td>
                                    <td>2023-09-12</td>
                                    <td><button class="btn btn-sm btn-primary">View Details</button></td>
                                </tr>
                                <tr>
                                    <td>Quality Education</td>
                                    <td>85%</td>
                                    <td>Europe</td>
                                    <td>2023-09-10</td>
                                    <td><button class="btn btn-sm btn-primary">View Details</button></td>
                                </tr>
                                <!-- More data rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
