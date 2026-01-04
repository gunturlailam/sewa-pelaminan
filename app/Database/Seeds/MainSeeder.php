<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        echo "\n";
        echo "╔══════════════════════════════════════════════════════════╗\n";
        echo "║       MANDAH PELAMINAN - DATABASE SEEDER                 ║\n";
        echo "╚══════════════════════════════════════════════════════════╝\n\n";

        echo "🔄 Memulai proses seeding...\n\n";

        // 1. Users (Admin & Petugas)
        echo "📁 [1/5] Seeding Users...\n";
        $this->call('UserSeeder');

        // 2. Paket Pelaminan
        echo "\n📁 [2/5] Seeding Paket Pelaminan...\n";
        $this->call('PaketSeeder');

        // 3. Pelaminan
        echo "\n📁 [3/5] Seeding Pelaminan...\n";
        $this->call('PelaminanSeeder');

        // 4. Pelanggan (termasuk user pelanggan)
        echo "\n📁 [4/5] Seeding Pelanggan...\n";
        $this->call('PelangganSeeder');

        // 5. Transaksi (Penyewaan, Detail, Pembayaran, Pengembalian)
        echo "\n📁 [5/5] Seeding Transaksi...\n";
        $this->call('TransaksiSeeder');

        echo "\n";
        echo "╔══════════════════════════════════════════════════════════╗\n";
        echo "║                    SEEDING SELESAI!                      ║\n";
        echo "╠══════════════════════════════════════════════════════════╣\n";
        echo "║  AKUN LOGIN:                                             ║\n";
        echo "║  ┌─────────────┬─────────────┬──────────────────┐        ║\n";
        echo "║  │ Role        │ Username    │ Password         │        ║\n";
        echo "║  ├─────────────┼─────────────┼──────────────────┤        ║\n";
        echo "║  │ Admin       │ admin       │ admin123         │        ║\n";
        echo "║  │ Petugas     │ petugas     │ petugas123       │        ║\n";
        echo "║  │ Pelanggan   │ budi        │ budi123          │        ║\n";
        echo "║  │ Pelanggan   │ siti        │ siti123          │        ║\n";
        echo "║  │ Pelanggan   │ ahmad       │ ahmad123         │        ║\n";
        echo "║  │ Pelanggan   │ dewi        │ dewi123          │        ║\n";
        echo "║  │ Pelanggan   │ rudi        │ rudi123          │        ║\n";
        echo "║  └─────────────┴─────────────┴──────────────────┘        ║\n";
        echo "║                                                          ║\n";
        echo "║  DATA YANG DIBUAT:                                       ║\n";
        echo "║  • 3 Users (Admin & Petugas)                             ║\n";
        echo "║  • 5 Paket Pelaminan                                     ║\n";
        echo "║  • 10 Pelaminan                                          ║\n";
        echo "║  • 5 Pelanggan                                           ║\n";
        echo "║  • 10 Transaksi Penyewaan (Jan-Okt 2025)                 ║\n";
        echo "║  • 12 Pembayaran (Lunas & Piutang)                       ║\n";
        echo "║  • 5 Pengembalian (dengan variasi denda)                 ║\n";
        echo "╚══════════════════════════════════════════════════════════╝\n\n";
    }
}
