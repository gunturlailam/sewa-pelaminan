# 📋 Use Case & Role-Based Access Control (RBAC)

Dokumentasi hak akses dan alur penggunaan aplikasi **Mandah Pelaminan**.

---

## 🔐 Sistem Role-Based Access Control

Aplikasi ini menggunakan 3 role utama dengan hak akses berbeda:

| Role          | Deskripsi                      | Target Pengguna        |
| ------------- | ------------------------------ | ---------------------- |
| **Admin**     | Full akses ke seluruh sistem   | Pemilik usaha, Manager |
| **Petugas**   | Akses operasional harian       | Staff, Kasir, Operator |
| **Pelanggan** | Akses terbatas untuk pelanggan | Customer, Penyewa      |

---

## 👑 Role: ADMIN

Admin memiliki **full akses** ke seluruh fitur aplikasi.

### Hak Akses Admin:

| Modul                      | Create | Read | Update | Delete |
| -------------------------- | :----: | :--: | :----: | :----: |
| **Master Paket**           |   ✅   |  ✅  |   ✅   |   ✅   |
| **Master Pelaminan**       |   ✅   |  ✅  |   ✅   |   ✅   |
| **Master Pelanggan**       |   ✅   |  ✅  |   ✅   |   ✅   |
| **Master Users**           |   ✅   |  ✅  |   ✅   |   ✅   |
| **Transaksi Penyewaan**    |   ✅   |  ✅  |   ✅   |   ✅   |
| **Transaksi Pembayaran**   |   ✅   |  ✅  |   ✅   |   ✅   |
| **Transaksi Pengembalian** |   ✅   |  ✅  |   ✅   |   ✅   |
| **Laporan Penyewaan**      |   -    |  ✅  |   -    |   -    |
| **Laporan Keuangan**       |   -    |  ✅  |   -    |   -    |
| **Laporan Logistik**       |   -    |  ✅  |   -    |   -    |
| **Laporan Pelanggan**      |   -    |  ✅  |   -    |   -    |
| **Cetak Invoice**          |   -    |  ✅  |   -    |   -    |

### Fitur Khusus Admin:

- ✅ Manajemen semua user (tambah, edit, hapus, reset password)
- ✅ Mengubah status transaksi (booking → berjalan → selesai/batal)
- ✅ Menghapus data transaksi
- ✅ Akses ke semua laporan tanpa filter
- ✅ Melihat data semua pelanggan

---

## 👷 Role: PETUGAS

Petugas fokus pada **operasional harian** penyewaan.

### Hak Akses Petugas:

| Modul                      | Create | Read | Update | Delete |
| -------------------------- | :----: | :--: | :----: | :----: |
| **Master Paket**           |   ❌   |  ✅  |   ❌   |   ❌   |
| **Master Pelaminan**       |   ❌   |  ✅  |   ❌   |   ❌   |
| **Master Pelanggan**       |   ❌   |  ✅  |   ❌   |   ❌   |
| **Master Users**           |   ❌   |  ❌  |   ❌   |   ❌   |
| **Transaksi Penyewaan**    |   ✅   |  ✅  |   ❌   |   ❌   |
| **Transaksi Pembayaran**   |   ✅   |  ✅  |   ❌   |   ❌   |
| **Transaksi Pengembalian** |   ✅   |  ✅  |   ❌   |   ❌   |
| **Laporan Penyewaan**      |   -    |  ✅  |   -    |   -    |
| **Laporan Keuangan**       |   -    |  ✅  |   -    |   -    |
| **Laporan Logistik**       |   -    |  ✅  |   -    |   -    |
| **Laporan Pelanggan**      |   -    |  ✅  |   -    |   -    |
| **Cetak Invoice**          |   -    |  ✅  |   -    |   -    |

### Fitur Khusus Petugas:

- ✅ Input penyewaan baru untuk pelanggan
- ✅ Input pembayaran (DP, pelunasan)
- ✅ Proses pengembalian barang
- ✅ Melihat semua laporan
- ✅ Cetak invoice/nota
- ❌ Tidak bisa menghapus data
- ❌ Tidak bisa mengakses manajemen user

---

## 👤 Role: PELANGGAN

Pelanggan memiliki **akses terbatas** hanya untuk data miliknya sendiri.

### Hak Akses Pelanggan:

| Modul                      | Create | Read | Update | Delete |
| -------------------------- | :----: | :--: | :----: | :----: |
| **Master Paket**           |   ❌   |  ❌  |   ❌   |   ❌   |
| **Master Pelaminan**       |   ❌   |  ❌  |   ❌   |   ❌   |
| **Master Pelanggan**       |   ❌   |  ❌  |   ❌   |   ❌   |
| **Master Users**           |   ❌   |  ❌  |   ❌   |   ❌   |
| **Transaksi Penyewaan**    |  ✅\*  | ✅\* |   ❌   |   ❌   |
| **Transaksi Pembayaran**   |   ❌   | ✅\* |   ❌   |   ❌   |
| **Transaksi Pengembalian** |   ❌   | ✅\* |   ❌   |   ❌   |
| **Laporan Penyewaan**      |   -    |  ❌  |   -    |   -    |
| **Laporan Keuangan**       |   -    |  ❌  |   -    |   -    |
| **Laporan Logistik**       |   -    |  ❌  |   -    |   -    |
| **Riwayat Transaksi**      |   -    | ✅\* |   -    |   -    |
| **Profil**                 |   ❌   |  ✅  |   ✅   |   ❌   |
| **Cetak Invoice**          |   -    | ✅\* |   -    |   -    |

> \*) Hanya data milik sendiri (`WHERE id_pelanggan = session_id`)

### Fitur Khusus Pelanggan:

- ✅ Edit profil sendiri (nama, username, password)
- ✅ Input penyewaan mandiri (self-booking)
- ✅ Melihat riwayat transaksi sendiri
- ✅ Melihat status pembayaran sendiri
- ✅ Cetak invoice transaksi sendiri
- ❌ Tidak bisa melihat data pelanggan lain
- ❌ Tidak bisa mengakses laporan umum
- ❌ Tidak bisa mengakses master data

---

## 🔒 Implementasi Keamanan

### 1. Authentication Filter (`AuthFilter.php`)

Filter ini memastikan user sudah login sebelum mengakses halaman:

```php
// app/Filters/AuthFilter.php
public function before(RequestInterface $request, $arguments = null)
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/auth/login');
    }
}
```

### 2. Role Filter (`RoleFilter.php`)

Filter ini membatasi akses URL berdasarkan role:

```php
// app/Filters/RoleFilter.php
public function before(RequestInterface $request, $arguments = null)
{
    $role = session()->get('role');

    if (!in_array($role, $arguments)) {
        return redirect()->to('/dashboard')
            ->with('error', 'Akses ditolak');
    }
}
```

### 3. Konfigurasi Filter (`Config/Filters.php`)

```php
public array $filters = [
    'auth' => ['before' => ['dashboard/*', 'master/*', 'transaksi/*', 'laporan/*']],
    'role' => ['before' => [
        'master/users/*' => ['admin'],
        'laporan/keuangan/*' => ['admin', 'petugas'],
    ]]
];
```

### 4. Helper Functions (`auth_helper.php`)

```php
// Cek apakah user adalah admin
function isAdmin(): bool {
    return session()->get('role') === 'admin';
}

// Cek apakah user adalah petugas
function isPetugas(): bool {
    return session()->get('role') === 'petugas';
}

// Cek apakah user adalah pelanggan
function isPelanggan(): bool {
    return session()->get('role') === 'pelanggan';
}

// Cek apakah user memiliki salah satu role
function hasRole(array $roles): bool {
    return in_array(session()->get('role'), $roles);
}
```

### 5. Proteksi di Controller

```php
// Contoh proteksi di controller
public function delete($id)
{
    // Hanya admin yang bisa hapus
    if (!$this->hasRole([self::ROLE_ADMIN])) {
        return $this->denyAccess();
    }
    // ... proses hapus
}
```

### 6. Proteksi di View

```php
<!-- Tombol hanya muncul untuk admin -->
<?php if (isAdmin()): ?>
    <a href="<?= site_url('master/paket/delete/'.$id) ?>" class="btn btn-danger">
        Hapus
    </a>
<?php endif; ?>
```

---

## 🔄 Alur Proses Penyewaan

### Flow Diagram:

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│  PELANGGAN  │────▶│   BOOKING   │────▶│  PEMBAYARAN │────▶│ PENGEMBALIAN│
│   /PETUGAS  │     │  (Penyewaan)│     │    (DP)     │     │   (Selesai) │
└─────────────┘     └─────────────┘     └─────────────┘     └─────────────┘
      │                    │                   │                   │
      ▼                    ▼                   ▼                   ▼
   Login            Pilih Paket &       Bayar DP/Lunas      Kembalikan
   Sistem           Tanggal Sewa        via Petugas         Barang
```

### Langkah Detail:

#### 📝 STEP 1: Pelanggan Melakukan Booking

**Aktor:** Pelanggan atau Petugas

1. Login ke sistem
2. Masuk menu **Transaksi → Penyewaan → Tambah**
3. Isi form penyewaan:
   - Pilih pelanggan (jika petugas)
   - Tentukan tanggal sewa & tanggal kembali
   - Isi alamat acara
   - Pilih item pelaminan yang disewa
   - (Opsional) Input DP awal
4. Klik **Simpan**
5. Sistem membuat transaksi dengan status **"Booking"**
6. Status pelaminan berubah menjadi **"Disewa"**

#### 💰 STEP 2: Petugas Memvalidasi Pembayaran

**Aktor:** Petugas atau Admin

1. Pelanggan melakukan pembayaran (tunai/transfer)
2. Petugas masuk menu **Transaksi → Pembayaran → Tambah**
3. Pilih nomor transaksi penyewaan
4. Input jumlah pembayaran
5. Pilih metode pembayaran
6. Klik **Simpan**
7. Sistem mencatat pembayaran dan menghitung sisa tagihan

#### ✅ STEP 3: Proses Pengembalian

**Aktor:** Petugas atau Admin

1. Pelanggan mengembalikan barang setelah acara
2. Petugas masuk menu **Transaksi → Pengembalian → Tambah**
3. Pilih nomor transaksi penyewaan
4. Cek kondisi barang
5. Input denda (jika ada kerusakan/keterlambatan)
6. Klik **Simpan**
7. Status penyewaan berubah menjadi **"Selesai"**
8. Status pelaminan kembali menjadi **"Tersedia"**

---

## 📊 Matriks Akses Menu Sidebar

| Menu            | Admin | Petugas | Pelanggan |
| --------------- | :---: | :-----: | :-------: |
| Dashboard       |  ✅   |   ✅    |    ✅     |
| **Master**      |       |         |           |
| ├─ Paket        |  ✅   |   👁️    |    ❌     |
| ├─ Pelaminan    |  ✅   |   👁️    |    ❌     |
| ├─ Pelanggan    |  ✅   |   👁️    |    ❌     |
| └─ Users        |  ✅   |   ❌    |    ❌     |
| **Transaksi**   |       |         |           |
| ├─ Penyewaan    |  ✅   |   ✅    |   ✅\*    |
| ├─ Pembayaran   |  ✅   |   ✅    |   👁️\*    |
| └─ Pengembalian |  ✅   |   ✅    |   👁️\*    |
| **Laporan**     |       |         |           |
| ├─ Penyewaan    |  ✅   |   ✅    |    ❌     |
| ├─ Keuangan     |  ✅   |   ✅    |    ❌     |
| ├─ Logistik     |  ✅   |   ✅    |    ❌     |
| └─ Pelanggan    |  ✅   |   ✅    |    ❌     |
| **Akun Saya**   |       |         |           |
| ├─ Profil       |  ✅   |   ✅    |    ✅     |
| └─ Riwayat      |  ❌   |   ❌    |    ✅     |

**Keterangan:**

- ✅ = Full akses
- 👁️ = Hanya lihat (Read Only)
- ❌ = Tidak bisa akses
- \* = Hanya data milik sendiri

---

## 🛡️ Validasi Keamanan Tambahan

### 1. Validasi Kepemilikan Data

Untuk role Pelanggan, sistem selalu memvalidasi kepemilikan data:

```php
// Di controller
if ($this->isPelanggan()) {
    $pelangganId = session()->get('pelanggan_id');

    // Cek apakah data milik pelanggan ini
    if ($penyewaan['id_pelanggan'] != $pelangganId) {
        return $this->denyAccess();
    }
}
```

### 2. Validasi Form Penyewaan

- Tanggal sewa tidak boleh kemarin
- Tanggal kembali harus setelah tanggal sewa
- Durasi maksimal 7 hari
- Pelaminan tidak boleh bentrok jadwal
- DP minimal 30% dari total
- Alamat acara minimal 10 karakter

### 3. Session Management

```php
// Data yang disimpan di session saat login
session()->set([
    'user_id'      => $user['id_user'],
    'username'     => $user['username'],
    'nama'         => $user['nama'],
    'role'         => $user['role'],
    'pelanggan_id' => $pelanggan['id_pelanggan'] ?? null,
    'logged_in'    => true
]);
```

---

## 📱 Tampilan Menu Berdasarkan Role

### Admin View:

```
📊 Dashboard
📦 Master
   ├── Paket
   ├── Pelaminan
   ├── Pelanggan
   └── Users
💰 Transaksi
   ├── Penyewaan
   ├── Pembayaran
   └── Pengembalian
📈 Laporan
   ├── Penyewaan
   ├── Keuangan
   ├── Logistik
   └── Pelanggan
```

### Petugas View:

```
📊 Dashboard
📦 Master
   ├── Paket (Read Only)
   ├── Pelaminan (Read Only)
   └── Pelanggan (Read Only)
💰 Transaksi
   ├── Penyewaan
   ├── Pembayaran
   └── Pengembalian
📈 Laporan
   ├── Penyewaan
   ├── Keuangan
   ├── Logistik
   └── Pelanggan
```

### Pelanggan View:

```
📊 Dashboard
💰 Transaksi
   ├── Penyewaan (Data Sendiri)
   ├── Pembayaran (Data Sendiri)
   └── Pengembalian (Data Sendiri)
👤 Akun Saya
   ├── Profil
   └── Riwayat Transaksi
```

---

## ✅ Checklist Keamanan

- [x] Authentication dengan session
- [x] Password hashing (bcrypt)
- [x] CSRF Protection
- [x] Role-based access control
- [x] Filter untuk proteksi URL
- [x] Validasi kepemilikan data
- [x] Input validation
- [x] XSS Protection (esc() function)
- [x] SQL Injection Protection (Query Builder)

---

<p align="center">
  <strong>Mandah Pelaminan</strong><br>
  Role-Based Access Control Documentation<br>
  © 2026 Guntur Lailam Yuro
</p>
