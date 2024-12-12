<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Profile
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2 class="text-center mt-4 text-primary">Edit Profile</h2>
<div class="card shadow-lg mb-5">
    <div class="card-body">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php elseif (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= site_url('/app/profile/update/') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Form Fields -->
            <div class="row">
                <!-- Username Field -->
                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                            </svg>
                        </span>
                        <input type="text" id="username" name="username" value="<?= esc($user['username']) ?>" class="form-control" required>
                    </div>
                </div>

                <!-- Email Field -->
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                                <path d="M3 7l9 6l9 -6"></path>
                            </svg>
                        </span>
                        <input type="email" id="email" name="email" value="<?= esc($user['email']) ?>" class="form-control" required>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password (optional)</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 17v4"></path>
                                <path d="M10 20l4 -2"></path>
                                <path d="M10 18l4 2"></path>
                                <path d="M5 17v4"></path>
                                <path d="M3 20l4 -2"></path>
                                <path d="M3 18l4 2"></path>
                                <path d="M19 17v4"></path>
                                <path d="M17 20l4 -2"></path>
                                <path d="M17 18l4 2"></path>
                            </svg>
                        </span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
