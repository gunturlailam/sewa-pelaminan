<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<style>
    .profile-header {
        background: linear-gradient(135deg, #696cff 0%, #8b5cf6 50%, #a855f7 100%);
        border-radius: 20px;
        padding: 2.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        border: 3px solid rgba(255, 255, 255, 0.3);
        margin-bottom: 1rem;
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
    }

    .profile-role {
        display: inline-block;
        padding: 0.35rem 1rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        position: relative;
        z-index: 1;
    }

    .profile-card {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .profile-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .profile-card-header i {
        font-size: 1.25rem;
        color: #696cff;
    }

    .profile-card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #1e293b;
    }

    .profile-card-body {
        padding: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: #696cff;
    }

    .form-control {
        border: 2px solid rgba(148, 163, 184, 0.2);
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #696cff;
        box-shadow: 0 0 0 4px rgba(105, 108, 255, 0.1);
    }

    .form-control:disabled {
        background: #f8fafc;
        color: #94a3b8;
    }

    .input-group {
        position: relative;
    }

    .input-group .form-control {
        padding-right: 3rem;
    }

    .toggle-password {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 0;
        z-index: 10;
    }

    .toggle-password:hover {
        color: #696cff;
    }

    .password-hint {
        font-size: 0.8rem;
        color: #94a3b8;
        margin-top: 0.5rem;
    }

    .btn-save {
        background: linear-gradient(135deg, #696cff 0%, #8b5cf6 100%);
        border: none;
        border-radius: 12px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 15px rgba(105, 108, 255, 0.3);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(105, 108, 255, 0.4);
        color: white;
    }

    .info-card {
        background: linear-gradient(135deg, rgba(105, 108, 255, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
        border: 1px solid rgba(105, 108, 255, 0.1);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }

    .info-card p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .info-card i {
        color: #696cff;
    }

    /* Dark mode */
    [data-theme="dark"] .profile-card {
        background: #1e293b;
    }

    [data-theme="dark"] .profile-card-header h5,
    [data-theme="dark"] .form-label {
        color: #f1f5f9;
    }

    [data-theme="dark"] .form-control {
        background: #0f172a;
        border-color: rgba(148, 163, 184, 0.1);
        color: #f1f5f9;
    }

    [data-theme="dark"] .form-control:disabled {
        background: #1e293b;
        color: #64748b;
    }

    [data-theme="dark"] .info-card {
        background: rgba(105, 108, 255, 0.1);
        border-color: rgba(105, 108, 255, 0.2);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Profile Header -->
    <div class="profile-header animate-fade-in">
        <div class="d-flex align-items-center gap-4">
            <div class="profile-avatar">
                <?= strtoupper(substr($user['nama'], 0, 1)) ?>
            </div>
            <div>
                <h2 class="profile-name"><?= esc($user['nama']) ?></h2>
                <span class="profile-role"><?= ucfirst($user['role']) ?></span>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none;">
            <i class='bx bx-check-circle me-2'></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none;">
            <i class='bx bx-error-circle me-2'></i>
            <ul class="mb-0 ps-3">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <!-- Edit Profile Form -->
            <div class="profile-card animate-fade-in" style="animation-delay: 0.1s">
                <div class="profile-card-header">
                    <i class='bx bx-edit'></i>
                    <h5>Edit Profil</h5>
                </div>
                <div class="profile-card-body">
                    <div class="info-card">
                        <p><i class='bx bx-info-circle me-2'></i>Perbarui informasi profil Anda. Kosongkan field password jika tidak ingin mengubahnya.</p>
                    </div>

                    <form action="<?= site_url('profil/update') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label class="form-label">
                                <i class='bx bx-user'></i> Nama Lengkap
                            </label>
                            <input type="text" name="nama" class="form-control"
                                value="<?= old('nama', $user['nama']) ?>"
                                placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class='bx bx-at'></i> Username
                            </label>
                            <input type="text" name="username" class="form-control"
                                value="<?= old('username', $user['username']) ?>"
                                placeholder="Masukkan username" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class='bx bx-shield'></i> Role
                            </label>
                            <input type="text" class="form-control"
                                value="<?= ucfirst($user['role']) ?>" disabled>
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3 fw-semibold">
                            <i class='bx bx-lock-alt me-2' style="color: #696cff;"></i>Ubah Password
                        </h6>

                        <div class="form-group">
                            <label class="form-label">
                                <i class='bx bx-key'></i> Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Masukkan password baru">
                                <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                    <i class='bx bx-hide' id="password-icon"></i>
                                </button>
                            </div>
                            <p class="password-hint"><i class='bx bx-info-circle me-1'></i>Minimal 8 karakter. Kosongkan jika tidak ingin mengubah.</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class='bx bx-check-shield'></i> Konfirmasi Password
                            </label>
                            <div class="input-group">
                                <input type="password" name="password_confirm" id="password_confirm" class="form-control"
                                    placeholder="Ulangi password baru">
                                <button type="button" class="toggle-password" onclick="togglePassword('password_confirm')">
                                    <i class='bx bx-hide' id="password_confirm-icon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn-save">
                                <i class='bx bx-save'></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Account Info -->
            <div class="profile-card animate-fade-in" style="animation-delay: 0.2s">
                <div class="profile-card-header">
                    <i class='bx bx-info-circle'></i>
                    <h5>Info Akun</h5>
                </div>
                <div class="profile-card-body">
                    <div class="d-flex align-items-center mb-3 pb-3" style="border-bottom: 1px solid rgba(148, 163, 184, 0.1);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 40px; height: 40px; background: rgba(105, 108, 255, 0.1);">
                            <i class='bx bx-id-card' style="color: #696cff;"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">User ID</small>
                            <span class="fw-semibold">#<?= str_pad($user['id_user'], 4, '0', STR_PAD_LEFT) ?></span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 pb-3" style="border-bottom: 1px solid rgba(148, 163, 184, 0.1);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 40px; height: 40px; background: rgba(34, 197, 94, 0.1);">
                            <i class='bx bx-check-circle' style="color: #22c55e;"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Status</small>
                            <span class="badge" style="background: rgba(34, 197, 94, 0.15); color: #16a34a;">Aktif</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 40px; height: 40px; background: rgba(249, 115, 22, 0.1);">
                            <i class='bx bx-calendar' style="color: #f97316;"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Terdaftar</small>
                            <span class="fw-semibold"><?= date('d M Y', strtotime($user['created_at'] ?? 'now')) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="profile-card animate-fade-in mt-4" style="animation-delay: 0.3s">
                <div class="profile-card-header">
                    <i class='bx bx-shield-quarter'></i>
                    <h5>Tips Keamanan</h5>
                </div>
                <div class="profile-card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <i class='bx bx-check text-success me-2 mt-1'></i>
                            <small>Gunakan password yang kuat dengan kombinasi huruf, angka, dan simbol</small>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class='bx bx-check text-success me-2 mt-1'></i>
                            <small>Jangan bagikan password Anda kepada siapapun</small>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class='bx bx-check text-success me-2 mt-1'></i>
                            <small>Logout setelah selesai menggunakan aplikasi</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('bx-hide');
            icon.classList.add('bx-show');
        } else {
            field.type = 'password';
            icon.classList.remove('bx-show');
            icon.classList.add('bx-hide');
        }
    }
</script>

<?= $this->endSection() ?>