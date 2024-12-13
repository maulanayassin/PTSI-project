<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Data Processing
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Data Processing</h1>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Data Processing</h5>
        </div>
        <div class="card-body">
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

            <p class="text-muted mb-4">Select the domains you want to process and click the button below to start processing the data into the system.</p>
            <form action="<?= site_url('app/dataprocessing/processData') ?>" method="post">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="domains[]" value="domain_1" id="domain1">
                    <label class="form-check-label" for="domain1">Domain 1 - Update values based on growth rate</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="domains[]" value="domain_2" id="domain2">
                    <label class="form-check-label" for="domain2">Domain 2 - Update values with verification validation (TRUE or FALSE)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="domains[]" value="domain_3A" id="domain3A">
                    <label class="form-check-label" for="domain3A">Domain 3A - Calculation based on fixed value and validation</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="domains[]" value="domain_3B" id="domain3B">
                    <label class="form-check-label" for="domain3B">Domain 3B - Calculation based on fixed value and grouping</label>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-success btn-lg">Start Data Processing</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5>Process Information</h5>
        </div>
        <div class="card-body">
            <p>
                This process will update data in various domains including Domain 1, Domain 2, Domain 3A, and Domain 3B.
                Additionally, the system will also update calculations in achievement and grading after the processing is complete.
            </p>
            <ul>
                <li><strong>Domain 1:</strong> Update values based on growth rate.</li>
                <li><strong>Domain 2:</strong> Update values with verification validation (TRUE or FALSE).</li>
                <li><strong>Domain 3A and 3B:</strong> Use calculations based on fixed value and data grouping.</li>
                <li><strong>Achievement</strong> and <strong>Grading</strong> calculations will be performed after the processing is complete.</li>
            </ul>
            <p class="text-muted">This process requires an active database connection and sufficient time depending on the data size.</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>