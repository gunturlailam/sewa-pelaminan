# 👑 Mandah Pelaminan

Sistem Manajemen Penyewaan Pelaminan berbasis CodeIgniter 4 dengan tampilan modern UI/UX 2026.

![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.x-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📋 Deskripsi Proyek

**Mandah Pelaminan** adalah aplikasi web untuk mengelola bisnis penyewaan pelaminan (dekorasi pernikahan). Aplikasi ini mencakup:

- 📦 **Manajemen Master Data** - Paket, Pelaminan, Pelanggan, Users
- 💰 **Transaksi** - Penyewaan, Pembayaran, Pengembalian
- 📊 **Laporan** - Penyewaan, Keuangan, Logistik, Riwayat Pelanggan
- 🔐 **Role-Based Access Control (RBAC)** - Admin, Petugas, Pelanggan
- 🖨️ **Cetak Invoice** - Nota profesional siap cetak
- 🌙 **Dark Mode** - Tampilan modern dengan toggle tema
- 📱 **Responsive** - Optimal di desktop dan mobile
- 🔌 **Offline Ready** - Semua aset tersimpan lokal

---

## ⚙️ Prasyarat (Prerequisites)

Pastikan sistem Anda memenuhi persyaratan berikut:

| Komponen        | Versi Minimum  | Rekomendasi     |
| --------------- | -------------- | --------------- |
| PHP             | 8.1            | 8.2+            |
| MySQL / MariaDB | 5.7 / 10.4     | 8.0 / 10.6+     |
| Composer        | 2.0            | 2.5+            |
| Web Server      | Apache / Nginx | Laragon / XAMPP |

### Ekstensi PHP yang Dibutuhkan:

- `intl`
- `mbstring`
- `json`
- `mysqlnd`
- `curl`

---

## 🚀 Langkah Instalasi

### 1️⃣ Clone atau Ekstrak Proyek

**Via Git:**

```bash
git clone https://github.com/username/mandah-pelaminan.git
cd mandah-pelaminan
```

**Via ZIP:**

- Download dan ekstrak file ZIP
- Pindahkan folder ke direktori web server (misal: `htdocs` atau `www`)

---

### 2️⃣ Install Dependencies

Jalankan Composer untuk menginstall semua dependencies:

```bash
composer install
```

Atau jika sudah ada `vendor` folder:

```bash
composer update
```

---

### 3️⃣ Konfigurasi Environment

**a. Salin file `.env`:**

```bash
# Windows
copy env .env

# Linux/Mac
cp env .env
```

**b. Edit file `.env` dan sesuaikan konfigurasi:**

```env
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------
CI_ENVIRONMENT = development

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------
app.baseURL = 'http://localhost:8080/'

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------
database.default.hostname = localhost
database.default.database = mandah_pelaminan
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

> ⚠️ **Penting:** Sesuaikan `app.baseURL` dengan URL server Anda.

---

### 4️⃣ Buat Database

Buat database baru di MySQL/MariaDB:

```sql
CREATE DATABASE mandah_pelaminan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau via phpMyAdmin/HeidiSQL, buat database dengan nama `mandah_pelaminan`.

---

### 5️⃣ Jalankan Migrasi Database

Migrasi akan membuat semua tabel yang dibutuhkan:

```bash
php spark migrate
```

Output yang diharapkan:

```
Running all new migrations...
Done.
```

---

### 6️⃣ Jalankan Seeder (Data Awal)

Seeder akan mengisi data dummy untuk testing:

```bash
php spark db:seed MainSeeder
```

Output yang diharapkan:

```
Seeding: MainSeeder
Seeded: MainSeeder
```

> 💡 **Tip:** MainSeeder akan menjalankan semua sub-seeder (Users, Pelanggan, Paket, Pelaminan, Transaksi).

---

### 7️⃣ Jalankan Aplikasi

**Menggunakan PHP Built-in Server:**

```bash
php spark serve
```

Aplikasi akan berjalan di: **http://localhost:8080**

**Menggunakan Laragon/XAMPP:**

Akses langsung via browser: `http://localhost/mandah-pelaminan/public`

---

## 🔑 Akun Dummy (Login)

Setelah menjalankan seeder, gunakan akun berikut untuk login:

| Role          | Username    | Password       | Hak Akses                             |
| ------------- | ----------- | -------------- | ------------------------------------- |
| **Admin**     | `admin`     | `admin123`     | Full akses semua fitur                |
| **Petugas**   | `petugas`   | `petugas123`   | Input transaksi & lihat laporan       |
| **Pelanggan** | `pelanggan` | `pelanggan123` | Edit profil & lihat transaksi sendiri |

---

## 📁 Struktur Folder

```
mandah-pelaminan/
├── app/
│   ├── Config/          # Konfigurasi aplikasi
│   ├── Controllers/     # Controller (Master, Transaksi, Laporan)
│   ├── Database/
│   │   ├── Migrations/  # File migrasi database
│   │   └── Seeds/       # File seeder
│   ├── Filters/         # Auth & Role filters
│   ├── Helpers/         # Helper functions
│   ├── Models/          # Model database
│   ├── Validation/      # Custom validation rules
│   └── Views/           # Template views
│       ├── auth/        # Login page
│       ├── dashboard.php
│       ├── index.php    # Main layout
│       ├── master/      # CRUD Master
│       ├── transaksi/   # CRUD Transaksi
│       ├── laporan/     # Laporan
│       └── profil.php   # Edit profil
├── public/
│   ├── assets/          # Aset lokal (CSS, JS, Fonts)
│   │   ├── css/
│   │   ├── js/
│   │   ├── fonts/
│   │   └── vendor/
│   └── index.php        # Entry point
├── .env                 # Environment config
├── composer.json
└── README.md
```

---

## 🎨 Struktur Aset (Offline Mode)

Aplikasi ini dirancang untuk berjalan **100% offline** tanpa CDN eksternal.

Semua aset tersimpan di `public/assets/`:

```
public/assets/
├── css/
│   ├── app.css              # Custom CSS aplikasi
│   └── bootstrap.min.css    # Bootstrap 5
├── js/
│   ├── app.js               # Custom JavaScript
│   ├── bootstrap.bundle.min.js
│   └── datatables/          # DataTables plugin
├── fonts/
│   └── plus-jakarta-sans/   # Font lokal
└── vendor/
    ├── boxicons/            # Ikon Boxicons
    └── css/                 # Template CSS
```

> 📖 Lihat `PANDUAN_OFFLINE_ASSETS.md` untuk panduan lengkap download aset.

---

## 🛠️ Perintah Spark Berguna

```bash
# Jalankan server development
php spark serve

# Jalankan migrasi
php spark migrate

# Rollback migrasi
php spark migrate:rollback

# Refresh migrasi (rollback + migrate)
php spark migrate:refresh

# Jalankan seeder
php spark db:seed MainSeeder

# Buat controller baru
php spark make:controller NamaController

# Buat model baru
php spark make:model NamaModel

# Buat migrasi baru
php spark make:migration create_nama_table

# Clear cache
php spark cache:clear
```

---

## 📊 Fitur Aplikasi

### 👤 Berdasarkan Role:

**Admin:**

- ✅ Full CRUD semua data master
- ✅ Full CRUD semua transaksi
- ✅ Akses semua laporan
- ✅ Manajemen users

**Petugas:**

- ✅ Lihat data master
- ✅ Input penyewaan & pembayaran
- ✅ Proses pengembalian
- ✅ Akses laporan

**Pelanggan:**

- ✅ Edit profil sendiri
- ✅ Lihat transaksi sendiri
- ✅ Input penyewaan mandiri
- ✅ Lihat riwayat transaksi

---

## 🔒 Keamanan

- Password di-hash menggunakan `password_hash()` (bcrypt)
- CSRF Protection aktif
- Session-based authentication
- Role-based access control di setiap controller
- Validasi input ketat pada form penyewaan

---

## 🐛 Troubleshooting

### Error: "Whoops! We seem to have hit a snag"

- Pastikan `CI_ENVIRONMENT = development` di `.env` untuk melihat detail error

### Error: Database connection

- Cek konfigurasi database di `.env`
- Pastikan MySQL/MariaDB sudah berjalan
- Pastikan database sudah dibuat

### Error: Class not found

- Jalankan `composer dump-autoload`

### Halaman blank / 500 Error

- Cek permission folder `writable/` (chmod 777 di Linux)
- Cek log error di `writable/logs/`

---

## 📝 Changelog

### v1.0.0 (2026)

- Initial release
- CRUD Master (Paket, Pelaminan, Pelanggan, Users)
- CRUD Transaksi (Penyewaan, Pembayaran, Pengembalian)
- Laporan (Penyewaan, Keuangan, Logistik, Pelanggan)
- Role-Based Access Control
- Modern UI/UX 2026 dengan Dark Mode
- Cetak Invoice
- Offline-ready assets

---

## 👨‍💻 Developer

**Guntur Lailam Yuro**

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

## 🙏 Credits

- [CodeIgniter 4](https://codeigniter.com/)
- [Bootstrap 5](https://getbootstrap.com/)
- [Boxicons](https://boxicons.com/)
- [Sneat Template](https://themeselection.com/item/sneat-free-bootstrap-html-admin-template/)
- [Plus Jakarta Sans Font](https://fonts.google.com/specimen/Plus+Jakarta+Sans)

---

<p align="center">
  Made with ❤️ by Guntur Lailam Yuro
</p>
