<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Home Page
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- <h2>Welcome to My Website</h2>
<p>This is the home page.</p> -->
<div class="page-wrapper">
        <!-- <div class="page-header d-print-none">
          <div class="container">
            <div class="row g-3 align-items-center">
              <div class="col-auto">
                <span class="status-indicator status-green status-indicator-animated">
                  <span class="status-indicator-circle"></span>
                  <span class="status-indicator-circle"></span>
                  <span class="status-indicator-circle"></span>
                </span>
              </div>
              <div class="col">
                <h2 class="page-title">
                  tabler-icons.io
                </h2>
                <div class="text-secondary">
                  <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><span class="text-green">Up</span></li>
                    <li class="list-inline-item">Checked every 3 minutes</li>
                  </ul>
                </div>
              </div>
              <div class="col-md-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="#" class="btn">
                    Download SVG icon from http://tabler-icons.io/i/settings -->
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path></svg>
                    Configure
                  </a>
                  <a href="#" class="btn btn-primary">
                    Download SVG icon from http://tabler-icons.io/i/player-pause -->
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 5m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v12a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path><path d="M14 5m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v12a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path></svg>
                    Pause this monitor
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div> --> 
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-cards">
              <div class="col-md-4">
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
              <div class="col-12">
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
              </div>
            </div>
          </div>
        </div>
      </div>
    
<?= $this->endSection() ?>