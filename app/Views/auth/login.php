<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mandah Pelaminan</title>

    <!-- Font Lokal -->
    <link rel="stylesheet" href="<?= base_url('assets/fonts/plus-jakarta-sans/plus-jakarta-sans.css') ?>">

    <!-- Bootstrap 5 Lokal -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>">

    <!-- Boxicons Lokal -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css') ?>">

    <style>
        :root {
            --primary-color: #696cff;
            --primary-hover: #5f61e6;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 420px;
            width: 100%;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #8592ff 100%);
            padding: 2rem;
            text-align: center;
            color: #fff;
        }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            opacity: 0.9;
            margin: 0;
            font-size: 0.9rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 500;
            color: #566a7f;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #d9dee3;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.15);
        }

        .input-group-text {
            background: #f5f5f9;
            border: 1px solid #d9dee3;
            border-radius: 8px 0 0 8px;
            color: #697a8d;
        }

        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }

        .btn-login {
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            color: #fff;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(105, 108, 255, 0.4);
        }

        .alert {
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .password-toggle {
            cursor: pointer;
            border-radius: 0 8px 8px 0 !important;
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            color: #697a8d;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <i class="bx bx-crown" style="font-size: 3rem; margin-bottom: 0.5rem;"></i>
            <h1>Mandah Pelaminan</h1>
            <p>Sistem Manajemen Penyewaan</p>
        </div>

        <div class="login-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bx bx-error-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="bx bx-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('auth/login') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Masukkan username" value="<?= old('username') ?>" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Masukkan password" required>
                        <span class="input-group-text password-toggle" onclick="togglePassword()">
                            <i class="bx bx-hide" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bx bx-log-in me-1"></i> Masuk
                </button>
            </form>

            <div class="footer-text">
                &copy; <?= date('Y') ?> Mandah Pelaminan<br>
                <small>Developed by Guntur Lailam Yuro</small>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            } else {
                password.type = 'password';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            }
        }
    </script>
</body>

</html>