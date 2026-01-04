# Panduan Setup Aset Offline - Mandah Pelaminan

## 📁 Struktur Folder Aset

```
public/
├── assets/
│   ├── css/
│   │   ├── bootstrap.min.css          # Bootstrap 5
│   │   ├── app.css                    # Custom CSS aplikasi
│   │   └── print.css                  # CSS untuk cetak
│   │
│   ├── js/
│   │   ├── bootstrap.bundle.min.js    # Bootstrap 5 JS + Popper
│   │   ├── jquery.min.js              # jQuery (opsional)
│   │   ├── sweetalert2.min.js         # SweetAlert2
│   │   ├── app.js                     # Custom JS aplikasi
│   │   └── datatables/
│   │       ├── jquery.dataTables.min.js
│   │       └── dataTables.bootstrap5.min.js
│   │
│   ├── vendor/
│   │   ├── boxicons/
│   │   │   ├── css/
│   │   │   │   └── boxicons.min.css
│   │   │   └── fonts/
│   │   │       ├── boxicons.woff2
│   │   │       ├── boxicons.woff
│   │   │       └── boxicons.ttf
│   │   │
│   │   └── fontawesome/               # Alternatif ikon
│   │       ├── css/
│   │       │   └── all.min.css
│   │       └── webfonts/
│   │           ├── fa-solid-900.woff2
│   │           ├── fa-regular-400.woff2
│   │           └── fa-brands-400.woff2
│   │
│   ├── fonts/
│   │   └── plus-jakarta-sans/
│   │       ├── PlusJakartaSans-Regular.woff2
│   │       ├── PlusJakartaSans-Medium.woff2
│   │       ├── PlusJakartaSans-SemiBold.woff2
│   │       ├── PlusJakartaSans-Bold.woff2
│   │       └── plus-jakarta-sans.css
│   │
│   └── img/
│       ├── favicon/
│       │   └── favicon.ico
│       └── logo.png
```

---

## 📥 Download Library yang Dibutuhkan

### 1. Bootstrap 5

- **URL:** https://getbootstrap.com/docs/5.3/getting-started/download/
- **Download:** Compiled CSS and JS
- **File yang dibutuhkan:**
  - `bootstrap.min.css` → `public/assets/css/`
  - `bootstrap.bundle.min.js` → `public/assets/js/`

### 2. jQuery (Opsional, untuk DataTables)

- **URL:** https://jquery.com/download/
- **Download:** Compressed, production jQuery
- **File:** `jquery.min.js` → `public/assets/js/`

### 3. SweetAlert2

- **URL:** https://sweetalert2.github.io/#download
- **Download:** sweetalert2.all.min.js
- **File:** `sweetalert2.min.js` → `public/assets/js/`
- **CSS:** `sweetalert2.min.css` → `public/assets/css/`

### 4. DataTables (Opsional)

- **URL:** https://datatables.net/download/
- **Pilih:** DataTables + Bootstrap 5 styling
- **Files:**
  - `jquery.dataTables.min.js` → `public/assets/js/datatables/`
  - `dataTables.bootstrap5.min.js` → `public/assets/js/datatables/`
  - `dataTables.bootstrap5.min.css` → `public/assets/css/`

### 5. Boxicons (Ikon yang digunakan)

- **URL:** https://boxicons.com/
- **Download:** https://github.com/atisawd/boxicons/releases
- **Extract dan copy:**
  - `css/boxicons.min.css` → `public/assets/vendor/boxicons/css/`
  - `fonts/*` → `public/assets/vendor/boxicons/fonts/`

### 6. Font Awesome (Alternatif Ikon)

- **URL:** https://fontawesome.com/download
- **Download:** Free for Web
- **Extract dan copy:**
  - `css/all.min.css` → `public/assets/vendor/fontawesome/css/`
  - `webfonts/*` → `public/assets/vendor/fontawesome/webfonts/`

---

## 🔤 Setup Font Lokal (Plus Jakarta Sans)

### Cara Download Google Fonts:

1. Buka https://fonts.google.com/specimen/Plus+Jakarta+Sans
2. Pilih styles: Regular (400), Medium (500), SemiBold (600), Bold (700)
3. Gunakan tool: https://google-webfonts-helper.herokuapp.com/fonts/plus-jakarta-sans
4. Download dan extract ke `public/assets/fonts/plus-jakarta-sans/`

### Buat file CSS untuk font lokal:

Buat file `public/assets/fonts/plus-jakarta-sans/plus-jakarta-sans.css`:

```css
/* Plus Jakarta Sans - Regular */
@font-face {
  font-family: "Plus Jakarta Sans";
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url("./PlusJakartaSans-Regular.woff2") format("woff2");
}

/* Plus Jakarta Sans - Medium */
@font-face {
  font-family: "Plus Jakarta Sans";
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url("./PlusJakartaSans-Medium.woff2") format("woff2");
}

/* Plus Jakarta Sans - SemiBold */
@font-face {
  font-family: "Plus Jakarta Sans";
  font-style: normal;
  font-weight: 600;
  font-display: swap;
  src: url("./PlusJakartaSans-SemiBold.woff2") format("woff2");
}

/* Plus Jakarta Sans - Bold */
@font-face {
  font-family: "Plus Jakarta Sans";
  font-style: normal;
  font-weight: 700;
  font-display: swap;
  src: url("./PlusJakartaSans-Bold.woff2") format("woff2");
}
```

---

## 🔧 Update Boxicons untuk Offline

Edit file `public/assets/vendor/boxicons/css/boxicons.min.css`:
Pastikan path font mengarah ke folder lokal:

```css
@font-face {
  font-family: "boxicons";
  src: url("../fonts/boxicons.woff2") format("woff2"), url("../fonts/boxicons.woff")
      format("woff"), url("../fonts/boxicons.ttf") format("truetype");
  font-weight: normal;
  font-style: normal;
}
```

---

## 📝 Pemanggilan di Layout

Lihat file `app/Views/layouts/offline_template.php` yang sudah saya buat untuk contoh lengkap pemanggilan aset lokal.

---

## ✅ Checklist Download

- [ ] Bootstrap 5 CSS & JS
- [ ] jQuery (jika pakai DataTables)
- [ ] SweetAlert2 CSS & JS
- [ ] DataTables CSS & JS (opsional)
- [ ] Boxicons CSS & Fonts
- [ ] Plus Jakarta Sans Font Files
- [ ] Favicon & Logo

---

## 🚀 Tips Tambahan

1. **Minify CSS/JS:** Selalu gunakan versi `.min.css` dan `.min.js` untuk performa lebih baik.

2. **Cache Busting:** Tambahkan versi pada URL aset untuk menghindari cache browser:

   ```php
   <link rel="stylesheet" href="<?= base_url('assets/css/app.css?v=1.0.0') ?>">
   ```

3. **Preload Font:** Untuk performa lebih baik:

   ```html
   <link
     rel="preload"
     href="<?= base_url('assets/fonts/plus-jakarta-sans/PlusJakartaSans-Regular.woff2') ?>"
     as="font"
     type="font/woff2"
     crossorigin
   />
   ```

4. **Fallback Font:** Selalu sediakan fallback font:
   ```css
   font-family: "Plus Jakarta Sans", -apple-system, BlinkMacSystemFont, "Segoe UI",
     sans-serif;
   ```

---

## 📂 Struktur Akhir yang Direkomendasikan

Setelah semua file didownload, struktur folder `public/assets/` akan terlihat seperti ini:

```
public/assets/
├── css/
│   ├── bootstrap.min.css
│   ├── sweetalert2.min.css
│   ├── dataTables.bootstrap5.min.css
│   └── app.css
├── js/
│   ├── bootstrap.bundle.min.js
│   ├── jquery.min.js
│   ├── sweetalert2.min.js
│   ├── datatables/
│   │   ├── jquery.dataTables.min.js
│   │   └── dataTables.bootstrap5.min.js
│   └── app.js
├── vendor/
│   └── boxicons/
│       ├── css/boxicons.min.css
│       └── fonts/
│           ├── boxicons.woff2
│           ├── boxicons.woff
│           └── boxicons.ttf
├── fonts/
│   └── plus-jakarta-sans/
│       ├── PlusJakartaSans-Regular.woff2
│       ├── PlusJakartaSans-Medium.woff2
│       ├── PlusJakartaSans-SemiBold.woff2
│       ├── PlusJakartaSans-Bold.woff2
│       └── plus-jakarta-sans.css
└── img/
    ├── favicon/favicon.ico
    └── logo.png
```

Dengan struktur ini, aplikasi Anda akan berjalan 100% offline tanpa memerlukan koneksi internet!
