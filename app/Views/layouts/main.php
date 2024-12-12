<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="<?= csrf_token() ?>" />
    <title><?= $this->renderSection('title') ?></title>
    <!-- CSS files -->
    <link href="/dist/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
    <!-- Include page-specific styles if set -->
    <?php if (isset($styles)): ?>
        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" href="<?= $style ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <script>
    <?php echo "let site_url = '". site_url()."';\n"; ?>
    <?php echo "let base_url = '". base_url()."';\n"; ?>
    </script>
  </head>
  <body >
    <div class="page">
      <!-- Navbar -->
      <header class="navbar navbar-expand-md d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="flex gap-[27px] items-center">
            <img src="<?= base_url('dist/img/logo_id_survey.png') ?>" alt="ID Survey" width="110" height="32"> 
            <img src="<?= base_url('dist/img/logo_ptsi.png') ?>" alt="Surveyor Indonesia" width="40" height="32">
          </div>
          <div class="navbar-nav flex-row order-md-last">
            <div class="d-none d-md-flex">
              <a href="#" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <!-- Icon Dark Mode -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
              </a>
              <a href="#" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <!-- Icon Light Mode -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
              </a>
            </div>
            <div class="nav-item dropdown">
              <?php
              // Mendapatkan username dan menghasilkan inisial
              $username = session()->get('username') ?? 'User';
              $initials = implode('', array_map(fn($n) => strtoupper($n[0]), explode(' ', $username)));
              ?>
              <a href="#" class="nav-link d-flex align-items-center lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                  <span 
                      class="avatar avatar-sm enhanced-avatar" 
                      style="background-image: url('<?= base_url('/dist/static/avatars/000m.jpg') ?>')">
                      <?= esc($initials) ?>
                  </span>
                  <div class="d-none d-xl-block ps-2">
                      <div class="fw-bold text-dark"><?= esc($username) ?></div>
                      <div class="mt-1 small text-muted"><?= esc(session()->get('role')) ?></div>
                  </div>
                  <i class="ms-2 text-muted bi bi-chevron-down"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow shadow-lg p-2 border-0 rounded-3">
                <a href="<?= site_url('app/profile') ?>" class="dropdown-item d-flex align-items-center">
                  <i class="bi bi-person-circle me-2 text-primary"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= site_url('auth/logout') ?>" class="dropdown-item d-flex align-items-center">
                  <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout
                </a>
              </div>
            </div>
          </div>
        </div>
      </header>
      <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar">
            <div class="container-xl">
              <ul class="navbar-nav">

                <!-- Home -->
                <li class="nav-item <?= uri_string() === '' ? 'active' : '' ?>">
                  <a class="nav-link" href="/">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                      </svg>
                    </span>
                    <span class="nav-link-title">Home</span>
                  </a>
                </li>

                <!-- Data Master -->
                <li class="nav-item dropdown <?= uri_string() === 'app/province' || uri_string() === 'app/city' || uri_string() === 'app/indicator' ? 'active' : '' ?>">
                  <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                        <path d="M12 12l8 -4.5" />
                        <path d="M12 12l0 9" />
                        <path d="M12 12l-8 -4.5" />
                        <path d="M16 5.25l-8 4.5" />
                      </svg>
                    </span>
                    <span class="nav-link-title">Data Master</span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item <?= uri_string() === 'app/province' ? 'active' : '' ?>" href="<?= site_url('app/province') ?>">
                      <svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="icon icon-tabler icons-tabler-outline icon-tabler-notes">
                          <path
                            stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path
                            d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                          <path
                            d="M9 7l6 0" />
                          <path
                            d="M9 11l6 0" />
                          <path
                            d="M9 15l4 0" />
                        </svg>&nbsp;Province
                    </a>
                    <a class="dropdown-item <?= uri_string() === 'app/city' ? 'active' : '' ?>" href="<?= site_url('app/city') ?>">
                      <svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="icon icon-tabler icons-tabler-outline icon-tabler-notes">
                          <path
                            stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path
                            d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                          <path
                            d="M9 7l6 0" />
                          <path
                            d="M9 11l6 0" />
                          <path
                            d="M9 15l4 0" />
                        </svg>&nbsp;Regencies / Cities
                    </a>
                    <a class="dropdown-item <?= uri_string() === 'app/indicator' ? 'active' : '' ?>" href="<?= site_url('app/indicator') ?>">
                      <svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="icon icon-tabler icons-tabler-outline icon-tabler-notes">
                          <path
                            stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path
                            d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                          <path
                            d="M9 7l6 0" />
                          <path
                            d="M9 11l6 0" />
                          <path
                            d="M9 15l4 0" />
                        </svg>&nbsp;Indicator
                    </a>
                  </div>
                </li>

                <!-- Transaction -->
                <li class="nav-item <?= uri_string() === 'app/transaction' ? 'active' : '' ?>">
                  <a class="nav-link" href="<?= site_url('app/transaction') ?>">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                        <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                        <path d="M9 17v-5" />
                        <path d="M12 17v-1" />
                        <path d="M15 17v-3" />
                      </svg>
                    </span>
                    <span class="nav-link-title">Transaction</span>
                  </a>
                </li>

                <!-- Ranking -->
                <li class="nav-item <?= uri_string() === 'app/achievement' ? 'active' : '' ?>">
                  <a class="nav-link" href="<?= site_url('app/achievement') ?>">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 13a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                        <path d="M15 9a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                        <path d="M9 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                        <path d="M4 20h14" />
                      </svg>
                    </span>
                    <span class="nav-link-title">Ranking</span>
                  </a>
                </li>

                <!-- Admin -->
                <?php if (session()->get('role') !== 'user') : ?>
                <li class="nav-item dropdown <?= strpos(uri_string(), 'app/admin/users') !== false || strpos(uri_string(), 'app/dataprocessing') !== false ? 'active' : '' ?>">
                  <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5" />
                        <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M19.001 15.5v1.5" />
                        <path d="M19.001 21v1.5" />
                        <path d="M22.032 17.25l-1.299 .75" />
                        <path d="M17.27 20l-1.3 .75" />
                        <path d="M15.97 17.25l1.3 .75" />
                        <path d="M20.733 20l1.3 .75" />
                      </svg>
                    </span>
                    <span class="nav-link-title">Admin</span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item <?= strpos(uri_string(), 'app/admin/users') !== false ? 'active' : '' ?>" href="<?= site_url('app/admin/users') ?>">
                      <svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="icon icon-tabler icons-tabler-outline icon-tabler-notes">
                          <path
                            stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path
                            d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                          <path
                            d="M9 7l6 0" />
                          <path
                            d="M9 11l6 0" />
                          <path
                            d="M9 15l4 0" />
                        </svg>&nbsp;User
                    </a>
                    <a class="dropdown-item <?= strpos(uri_string(), 'app/dataprocessing') !== false ? 'active' : '' ?>" href="<?= site_url('app/dataprocessing') ?>">
                      <svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="icon icon-tabler icons-tabler-outline icon-tabler-notes">
                          <path
                            stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path
                            d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                          <path
                            d="M9 7l6 0" />
                          <path
                            d="M9 11l6 0" />
                          <path
                            d="M9 15l4 0" />
                        </svg>&nbsp;Data Processing
                      </a>
                  </div>
                </li>
                <?php endif; ?>

                <!-- Help -->
                <!-- <li class="nav-item dropdown <?= uri_string() === 'docs' || uri_string() === 'changelog.html' ? 'active' : '' ?>">
                  <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="nav-link-title">Help</span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="https://tabler.io/docs" target="_blank" rel="noopener">Documentation</a>
                    <a class="dropdown-item" href="/changelog.html">Changelog</a>
                  </div>
                </li> -->

              </ul>
            </div>
          </div>
        </div>
      </header>
      <div class="page-wrapper">
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl d-flex flex-column justify-content-center">

          <?= $this->renderSection('content') ?>
          
          </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item"><a href="https://tabler.io/docs" target="_blank" class="link-secondary" rel="noopener">Documentation</a></li>
                  <li class="list-inline-item"><a href="/license.html" class="link-secondary">License</a></li>
                </ul>
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Copyright &copy; 2023
                    <a href="." class="link-secondary">Tabler</a>.
                    All rights reserved.
                  </li>
                  <li class="list-inline-item">
                    <a href="/changelog.html" class="link-secondary" rel="noopener">
                      v1.0.0-beta20
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="/dist/js/tabler.min.js?1692870487" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" defer></script>
    <!-- Include page-specific JS if set -->
    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
  </body>
</html>
<script>
  // Mengambil elemen theme toggle
  const themeToggleDark = document.querySelector('.hide-theme-dark');
  const themeToggleLight = document.querySelector('.hide-theme-light');

  // Fungsi untuk mengaktifkan dark mode
  function enableDarkMode() {
    document.body.classList.add('dark-mode');
    document.querySelector('.navbar').classList.add('dark-mode');
    document.querySelector('.dropdown-menu').classList.add('dark-mode');
    document.querySelectorAll('.dropdown-item').forEach(item => item.classList.add('dark-mode'));
    localStorage.setItem('theme', 'dark');
  }

  // Fungsi untuk mengaktifkan light mode
  function enableLightMode() {
    document.body.classList.remove('dark-mode');
    document.querySelector('.navbar').classList.remove('dark-mode');
    document.querySelector('.dropdown-menu').classList.remove('dark-mode');
    document.querySelectorAll('.dropdown-item').forEach(item => item.classList.remove('dark-mode'));
    localStorage.setItem('theme', 'light');
  }

  // Periksa apakah ada preferensi tema yang disimpan di localStorage
  window.addEventListener('load', () => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
      enableDarkMode();
    } else {
      enableLightMode();
    }
  });

  // Event listener untuk toggle dark mode
  themeToggleDark.addEventListener('click', () => {
    enableDarkMode();
  });

  // Event listener untuk toggle light mode
  themeToggleLight.addEventListener('click', () => {
    enableLightMode();
  });
</script>
