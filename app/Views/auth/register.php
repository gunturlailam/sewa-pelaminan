<!DOCTYPE html>
<html lang="id" class="light-style customizer-hide" data-theme="theme-default">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Sistem Root Utama</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Boxicons -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css'); ?>">
    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css'); ?>">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Public Sans', Arial, sans-serif;
        }

        .authentication-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .authentication-inner {
            width: 100%;
            max-width: 420px;
        }

        .card {
            border-radius: 18px;
            box-shadow: 0 6px 24px rgba(105, 108, 255, 0.08);
            border: none;
        }

        .app-brand {
            margin-bottom: 1.5rem;
        }

        .app-brand-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #696cff;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            background: #696cff;
            border: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #5a5edc;
        }

        .input-group-text {
            background: #f5f5f9;
            border: none;
        }

        .form-control:focus {
            box-shadow: 0 0 0 2px #696cff33;
        }

        .text-muted {
            color: #a1a7b3 !important;
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body p-4">
                        <div class="app-brand justify-content-center">
                            <span class="app-brand-logo demo">
                                <!-- Simple SVG logo -->
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="32" height="32" rx="8" fill="#696cff" />
                                    <text x="16" y="21" text-anchor="middle" fill="#fff" font-size="16" font-family="Arial" font-weight="bold">SR</text>
                                </svg>
                            </span>
                            <span class="app-brand-text demo">Root</span>
                        </div>
                        <h4 class="mb-2 text-center">Buat Akun Baru</h4>
                        <p class="mb-4 text-center">Daftarkan akun admin Anda untuk mengakses sistem</p>
                        <form action="<?= base_url('auth/proses_register'); ?>" method="POST" class="mb-3">
                            <?= csrf_field(); ?>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                                <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="********" required>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Daftar</button>
                            </div>
                        </form>
                        <p class="text-center mb-0">
                            <span>Sudah punya akun?</span>
                            <a href="<?= base_url('auth/login'); ?>"><span>Masuk</span></a>
                        </p>
                    </div>
                </div>
                <div class="text-center text-muted small mt-3">
                    &copy; <?= date('Y'); ?> Root Control
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>
</body>

</html>