<!DOCTYPE html>
<html lang="id" class="light-style layout-menu-fixed" dir="ltr" data-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?= $title ?? 'Mandah Pelaminan' ?></title>

    <!-- Favicon (Lokal) -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico') ?>" />

    <!-- ============================================
         FONT LOKAL - Plus Jakarta Sans
         Download dari: https://fonts.google.com/specimen/Plus+Jakarta+Sans
         Gunakan tool: https://google-webfonts-helper.herokuapp.com/
    ============================================ -->
    <link rel="preload" href="<?= base_url('assets/fonts/plus-jakarta-sans/PlusJakartaSans-Regular.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= base_url('assets/fonts/plus-jakarta-sans/plus-jakarta-sans.css') ?>" />

    <!-- ============================================
         IKON LOKAL - Boxicons
         Download dari: https://github.com/atisawd/boxicons/releases
    ============================================ -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/boxicons/css/boxicons.min.css') ?>" />

    <!-- ============================================
         CSS FRAMEWORK - Bootstrap 5
         Download dari: https://getbootstrap.com/docs/5.3/getting-started/download/
    ============================================ -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />

    <!-- ============================================
         CSS PLUGINS (Opsional)
    ============================================ -->
    <!-- SweetAlert2 - Download: https://sweetalert2.github.io/#download -->
    <link rel="stylesheet" href="<?= base_url('assets/css/sweetalert2.min.css') ?>" />

    <!-- DataTables - Download: https://datatables.net/download/ -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.bootstrap5.min.css') ?>" />

    <!-- ============================================
         CSS TEMPLATE SNEAT (Jika menggunakan)
    ============================================ -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />

    <!-- ============================================
         CSS CUSTOM APLIKASI
    ============================================ -->
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>" />

    <!-- ============================================
         MODERN UI/UX 2026 STYLES
    ============================================ -->
    <style>
        :root {
            --accent-gradient: linear-gradient(135deg, #696cff 0%, #8b5cf6 50%, #a855f7 100%);
            --radius-lg: 16px;
            --radius-xl: 20px;
        }

        * {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
        }

        body {
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Modern Sidebar */
        .layout-menu {
            background: linear-gradient(180deg, rgba(105, 108, 255, 0.03) 0%, rgba(255, 255, 255, 0.95) 100%) !important;
            backdrop-filter: blur(20px);
        }

        .app-brand-text {
            background: var(--accent-gradient);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Menu Items */
        .menu-item .menu-link {
            border-radius: 12px;
            margin: 2px 8px;
            transition: all 0.2s ease;
        }

        .menu-item .menu-link:hover {
            background: rgba(105, 108, 255, 0.08);
            transform: translateX(4px);
        }

        .menu-item.active>.menu-link {
            background: var(--accent-gradient) !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(105, 108, 255, 0.4);
        }

        /* Cards */
        .card {
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: var(--radius-xl);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        /* Buttons */
        .btn-primary {
            background: var(--accent-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(105, 108, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(105, 108, 255, 0.4);
        }

        /* Tables */
        .table thead th {
            background: rgba(105, 108, 255, 0.04);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.1);
        }

        /* Badges */
        .badge {
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
            font-weight: 500;
        }

        /* Theme Toggle */
        .theme-toggle {
            width: 40px;
            height: 40px;
            border: none;
            background: rgba(105, 108, 255, 0.1);
            border-radius: 12px;
            color: #696cff;
            cursor: pointer;
        }

        .theme-toggle:hover {
            background: #696cff;
            color: white;
        }

        /* Dark Mode */
        [data-theme="dark"] {
            --bs-body-bg: #0f172a;
        }

        [data-theme="dark"] .layout-menu {
            background: linear-gradient(180deg, rgba(105, 108, 255, 0.05) 0%, rgba(30, 41, 59, 0.98) 100%) !important;
        }

        [data-theme="dark"] .card {
            background: #1e293b;
        }

        /* Print */
        @media print {

            .layout-menu,
            .layout-navbar,
            .no-print {
                display: none !important;
            }

            .layout-page {
                margin-left: 0 !important;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.3);
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <?php helper('auth'); ?>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Sidebar Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="<?= site_url('dashboard') ?>" class="app-brand-link text-decoration-none">
                        <span class="app-brand-logo demo">
                            <i class='bx bx-crown' style="font-size: 1.75rem; color: #696cff;"></i>
                        </span>
                        <span class="app-brand-text fw-bold fs-4 ms-2">Mandah</span>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>
                <?= $this->include('menu') ?>
            </aside>
            <!-- / Sidebar Menu -->

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Cari..." />
                            </div>
                        </div>

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Theme Toggle -->
                            <li class="nav-item me-2">
                                <button class="theme-toggle" id="themeToggle" title="Toggle Dark Mode">
                                    <i class='bx bx-moon'></i>
                                </button>
                            </li>

                            <!-- User Dropdown -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background: var(--accent-gradient); color: white; font-weight: 600;">
                                        <?= strtoupper(substr(session()->get('nama') ?? 'U', 0, 1)) ?>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background: var(--accent-gradient); color: white; font-weight: 600;">
                                                        <?= strtoupper(substr(session()->get('nama') ?? 'U', 0, 1)) ?>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block"><?= session()->get('nama') ?? 'User' ?></span>
                                                    <small class="text-muted"><?= ucfirst(session()->get('role') ?? '') ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('profil') ?>">
                                            <i class="bx bx-user me-2"></i> Profil Saya
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="<?= site_url('auth/logout') ?>">
                                            <i class="bx bx-power-off me-2"></i> Log Out
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?= $this->renderSection('content') ?>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                © <script>
                                    document.write(new Date().getFullYear());
                                </script>, developed by
                                <span class="fw-bolder" style="background: var(--accent-gradient); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Guntur Lailam Yuro</span>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- ============================================
         JS FRAMEWORK - jQuery (Opsional, untuk DataTables)
         Download dari: https://jquery.com/download/
    ============================================ -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

    <!-- ============================================
         JS FRAMEWORK - Bootstrap 5
         Download dari: https://getbootstrap.com/docs/5.3/getting-started/download/
    ============================================ -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- ============================================
         JS PLUGINS
    ============================================ -->
    <!-- SweetAlert2 -->
    <script src="<?= base_url('assets/js/sweetalert2.min.js') ?>"></script>

    <!-- DataTables (Opsional) -->
    <script src="<?= base_url('assets/js/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/datatables/dataTables.bootstrap5.min.js') ?>"></script>

    <!-- ============================================
         JS TEMPLATE SNEAT (Jika menggunakan)
    ============================================ -->
    <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>
    <script src="<?= base_url('assets/js/config.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/menu.js') ?>"></script>
    <script src="<?= base_url('assets/js/main.js') ?>"></script>

    <!-- ============================================
         JS CUSTOM APLIKASI
    ============================================ -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>

    <!-- Theme Toggle Script -->
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        // Check saved theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            html.setAttribute('data-theme', savedTheme);
            if (savedTheme === 'dark') {
                html.classList.remove('light-style');
                html.classList.add('dark-style');
            }
        }
        updateThemeIcon();

        themeToggle?.addEventListener('click', () => {
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);

            if (next === 'dark') {
                html.classList.remove('light-style');
                html.classList.add('dark-style');
            } else {
                html.classList.remove('dark-style');
                html.classList.add('light-style');
            }
            updateThemeIcon();
        });

        function updateThemeIcon() {
            const icon = themeToggle?.querySelector('i');
            if (icon) {
                const isDark = html.getAttribute('data-theme') === 'dark';
                icon.className = isDark ? 'bx bx-sun' : 'bx bx-moon';
            }
        }

        // Initialize DataTables (jika ada tabel dengan class .datatable)
        $(document).ready(function() {
            if ($.fn.DataTable) {
                $('.datatable').DataTable({
                    language: {
                        url: '<?= base_url('assets/js/datatables/id.json') ?>'
                    }
                });
            }
        });
    </script>
</body>

</html>