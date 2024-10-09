<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Home Page
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- <h2>Welcome to My Website</h2>
<p>This is the home page.</p> -->
<div class="page-wrapper">
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <!-- SDG Introduction Section -->
                
                <!-- Embed iframe -->
                <div class="col-md-12" style="height: 600px;">
                    <iframe width="770" height="580" scrolling="no" 
                        src="https://v3.polymersearch.com/b/67035c3429b08d000849277c?m=embed&b=470e7222-e039-44cf-b0d0-3c0df5d28345&f=1&c=1"
                        style="overflow:hidden;height:100%;width:100%;position:relative;">
                    </iframe>
                </div>
                <div class="col-md-6" style="height: 500px;">
                    <iframe width="770" height="580" scrolling="no" 
                        src="https://v3.polymersearch.com/b/67035c3429b08d000849277c?m=embed&b=06823448-f1b2-409a-a053-8810e1e6347b&f=1&c=1"
                        style="overflow:hidden;height:100%;width:100%;position:relative;">
                    </iframe>
                </div>
                <div class="col-md-6" style="height: 500px;">
                    <iframe width="770" height="580" scrolling="no" 
                        src="https://v3.polymersearch.com/b/67035c3429b08d000849277c?m=embed&b=342178ee-b329-4539-9637-e3468ac5766e&f=1&c=1" 
                        style="overflow:hidden;height:100%;width:100%;position:relative;">
                    </iframe>
                </div>
                <div class="col-md-12" style="height:600px;">
                    <iframe width="770" height="580" scrolling="no" 
                        src="https://v3.polymersearch.com/b/67035c3429b08d000849277c?m=embed&b=02f2f448-7899-4cf4-b4ce-36b4511f4e02&f=1&c=1" 
                        style="overflow:hidden;height:100%;width:100%;position:relative;" >
                    </iframe>
                </div>
                <!-- <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="subheader">Currently up for</div>
                            <div class="h3 m-0">14 days 2 hours 54 mins 34 seconds</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="subheader">Last checked at</div>
                            <div class="h3 m-0">27 seconds ago</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="subheader">Incidents</div>
                            <div class="h3 m-0">3</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Response times across regions in the last day</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Uptime incidents per day</h3>
                        </div>
                    </div>
                </div>
                <class="col-12">
                    <div class="card">
                        <div class="card-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th>Time period</th>
                                    <th>Availability</th>
                                    <th>Downtime</th>
                                    <th>Incidents</th>
                                    <th>Longest incident</th>
                                    <th>Avg. incident</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td>Today</td>
                                    <td>98.9533%</td>
                                    <td>1 minute</td>
                                    <td>1</td>
                                    <td>1 minute</td>
                                    <td>1 minute</td>
                                    </tr>
                                    <tr>
                                    <td>Last 7 days</td>
                                    <td>98.9533%</td>
                                    <td>1 minute</td>
                                    <td>1</td>
                                    <td>1 minute</td>
                                    <td>1 minute</td>
                                    </tr>
                                    <tr>
                                    <td>Last 30 days</td>
                                    <td>98.9533%</td>
                                    <td>1 minute</td>
                                    <td>1</td>
                                    <td>1 minute</td>
                                    <td>1 minute</td>
                                    </tr>
                                    <tr>
                                    <td>Last 365 days</td>
                                    <td>98.9533%</td>
                                    <td>1 minute</td>
                                    <td>1</td>
                                    <td>1 minute</td>
                                    <td>1 minute</td>
                                    </tr>
                                    <tr>
                                    <td>All time</td>
                                    <td>98.9533%</td>
                                    <td>1 minute</td>
                                    <td>1</td>
                                    <td>1 minute</td>
                                    <td>1 minute</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> -->
            </div>            
        </div>
    </div>
</div> 
    
<?= $this->endSection() ?>