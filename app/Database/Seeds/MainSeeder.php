<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        echo "🚀 Menjalankan MainSeeder...\n\n";

        // 1. Users (Admin, Petugas, Pelanggan)
        $this->call('UserSeeder');

        // 2. Kategori Pelaminan
        $this->call('KategoriSeeder');

        // 3. Data Pelaminan Khas Minang
        $this->call('PelaminanSeeder');

        // 4. Data Pelanggan
        $this->call('PelangganSeeder');

        echo "\n✅ MainSeeder selesai!\n";
        echo "📝 Data master pelaminan khas Minangkabau berhasil ditambahkan.\n";
    }
}
