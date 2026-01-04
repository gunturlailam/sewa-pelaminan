<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PelaminanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_pelaminan' => 'Pelaminan Jawa Klasik',
                'jenis'          => 'Tradisional',
                'ukuran'         => '4x3 meter',
                'warna'          => 'Emas & Merah',
                'harga_sewa'     => 3500000,
                'stok'           => 2,
                'status'         => 'tersedia'
            ],
            [
                'nama_pelaminan' => 'Pelaminan Minang',
                'jenis'          => 'Tradisional',
                'ukuran'         => '4x3 meter',
                'warna'          => 'Merah & Kuning',
                'harga_sewa'     => 4000000,
                'stok'           => 2,
                'status'         => 'tersedia'
            ],
            [
                'nama_pelaminan' => 'Pelaminan Modern Minimalis',
                'jenis'          => 'Modern',
                'ukuran'         => '5x4 meter',
                'warna'          => 'Putih & Gold',
                'harga_sewa'     => 5000000,
                'stok'           => 3,
                'status'         => 'tersedia'
            ],
            [
                'nama_pelaminan' => 'Pelaminan Rustic Garden',
                'jenis'          => 'Modern',
                'ukuran'         => '6x4 meter',
                'warna'          => 'Hijau & Cream',
                'harga_sewa'     => 6000000,
                'stok'           => 2,
                'status'         => 'tersedia'
            ],
            [
                'nama_pelaminan' => 'Pelaminan Glamour',
                'jenis'          => 'Modern',
                'ukuran'         => '5x4 meter',
                'warna'          => 'Silver & Putih',
                'harga_sewa'     => 7500000,
                'stok'           => 2,
                'status'         => 'tersedia'
            ],
            [
                'nama_pelaminan' => 'Pelaminan Bugis',
                'jenis'          => 'Tradisional',
                'ukuran'         => '4x3 meter',
                'warna'          => 'Hijau & Emas',
                'harga_sewa'     => 3800000,
                'stok'           => 1,
                'status'         => 'tersedia'
            ],
            [
                'nama_pelaminan' => 'Pelaminan Sunda',
                'jenis'          => 'Tradisional',
                'ukuran'         => '4x3 meter',
                'warna'          => 'Kuning & Hijau',
                'harga_sewa'     => 3500000,
                'stok'           => 2,
                'status'         => 'tersedia'
            ],
            [
                'nama_pelaminan' => 'Pelaminan Luxury Royal',
                'jenis'          => 'Premium',
                'ukuran'         => '7x5 meter',
                'warna'          => 'Gold & Maroon',
                'harga_sewa'     => 12000000,
                'stok'           => 1,
                'status'         => 'tersedia'
            ],
            [
                'nama_pelaminan' => 'Backdrop Bunga Segar',
                'jenis'          => 'Aksesoris',
                'ukuran'         => '3x2 meter',
                'warna'          => 'Mix Flowers',
                'harga_sewa'     => 2500000,
                'stok'           => 5,
                'status'         => 'tersedia'
            ],
            [
                'nama_pelaminan' => 'Kursi Pengantin Set',
                'jenis'          => 'Aksesoris',
                'ukuran'         => '2 unit',
                'warna'          => 'Gold',
                'harga_sewa'     => 1500000,
                'stok'           => 4,
                'status'         => 'tersedia'
            ],
        ];

        $this->db->table('pelaminan')->insertBatch($data);
        echo "✅ PelaminanSeeder: " . count($data) . " pelaminan berhasil ditambahkan\n";
    }
}
