<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PelaminanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Kategori 1: Pelaminan Utama
            [
                'id_kategori'    => 1,
                'nama_pelaminan' => 'Pelaminan Minang Klasik',
                'jenis'          => 'Pelaminan',
                'ukuran'         => '3x4 meter',
                'warna'          => 'Merah Maroon & Emas',
                'harga_sewa'     => 15000000,
                'stok'           => 2,
                'status'         => 'tersedia'
            ],
            [
                'id_kategori'    => 1,
                'nama_pelaminan' => 'Pelaminan Minang Modern',
                'jenis'          => 'Pelaminan',
                'ukuran'         => '3x4 meter',
                'warna'          => 'Putih & Gold',
                'harga_sewa'     => 18000000,
                'stok'           => 2,
                'status'         => 'tersedia'
            ],
            [
                'id_kategori'    => 1,
                'nama_pelaminan' => 'Pelaminan Gonjong Premium',
                'jenis'          => 'Pelaminan',
                'ukuran'         => '4x5 meter',
                'warna'          => 'Merah & Emas',
                'harga_sewa'     => 25000000,
                'stok'           => 1,
                'status'         => 'tersedia'
            ],
            [
                'id_kategori'    => 1,
                'nama_pelaminan' => 'Pelaminan Rumah Gadang',
                'jenis'          => 'Pelaminan',
                'ukuran'         => '4x5 meter',
                'warna'          => 'Hitam & Emas',
                'harga_sewa'     => 22000000,
                'stok'           => 1,
                'status'         => 'tersedia'
            ],

            // Kategori 2: Dekorasi Ruangan
            [
                'id_kategori'    => 2,
                'nama_pelaminan' => 'Backdrop Ukiran Minang',
                'jenis'          => 'Backdrop',
                'ukuran'         => '3x2.5 meter',
                'warna'          => 'Coklat Kayu & Emas',
                'harga_sewa'     => 5000000,
                'stok'           => 3,
                'status'         => 'tersedia'
            ],
            [
                'id_kategori'    => 2,
                'nama_pelaminan' => 'Tirai Songket Minang',
                'jenis'          => 'Tirai',
                'ukuran'         => '2x3 meter',
                'warna'          => 'Merah & Emas',
                'harga_sewa'     => 2500000,
                'stok'           => 5,
                'status'         => 'tersedia'
            ],
            [
                'id_kategori'    => 2,
                'nama_pelaminan' => 'Lampu Gantung Tradisional',
                'jenis'          => 'Lampu',
                'ukuran'         => 'Diameter 80cm',
                'warna'          => 'Kuningan',
                'harga_sewa'     => 1500000,
                'stok'           => 4,
                'status'         => 'tersedia'
            ],
            [
                'id_kategori'    => 2,
                'nama_pelaminan' => 'Karpet Permadani Minang',
                'jenis'          => 'Karpet',
                'ukuran'         => '4x6 meter',
                'warna'          => 'Merah Maroon',
                'harga_sewa'     => 2000000,
                'stok'           => 3,
                'status'         => 'tersedia'
            ],

            // Kategori 3: Perlengkapan Adat
            [
                'id_kategori'    => 3,
                'nama_pelaminan' => 'Kursi Pengantin Ukir',
                'jenis'          => 'Kursi',
                'ukuran'         => '2 unit (sepasang)',
                'warna'          => 'Emas & Merah',
                'harga_sewa'     => 3500000,
                'stok'           => 3,
                'status'         => 'tersedia'
            ],
            [
                'id_kategori'    => 3,
                'nama_pelaminan' => 'Carano Adat',
                'jenis'          => 'Carano',
                'ukuran'         => 'Diameter 40cm',
                'warna'          => 'Kuningan',
                'harga_sewa'     => 500000,
                'stok'           => 10,
                'status'         => 'tersedia'
            ],
            [
                'id_kategori'    => 3,
                'nama_pelaminan' => 'Payung Pengantin',
                'jenis'          => 'Payung',
                'ukuran'         => 'Diameter 1.5 meter',
                'warna'          => 'Kuning Emas',
                'harga_sewa'     => 750000,
                'stok'           => 4,
                'status'         => 'tersedia'
            ],
            [
                'id_kategori'    => 3,
                'nama_pelaminan' => 'Dulang Tinggi',
                'jenis'          => 'Dulang',
                'ukuran'         => 'Tinggi 1 meter',
                'warna'          => 'Kuningan & Merah',
                'harga_sewa'     => 350000,
                'stok'           => 8,
                'status'         => 'tersedia'
            ],
            [
                'id_kategori'    => 3,
                'nama_pelaminan' => 'Tombak Adat',
                'jenis'          => 'Tombak',
                'ukuran'         => 'Tinggi 2 meter',
                'warna'          => 'Emas & Hitam',
                'harga_sewa'     => 400000,
                'stok'           => 6,
                'status'         => 'tersedia'
            ],

            // Kategori 4: Tenda & Kanopi
            [
                'id_kategori'    => 4,
                'nama_pelaminan' => 'Tenda Gonjong Minang',
                'jenis'          => 'Tenda',
                'ukuran'         => '10x10 meter',
                'warna'          => 'Putih & Merah',
                'harga_sewa'     => 8000000,
                'stok'           => 2,
                'status'         => 'tersedia'
            ],
            [
                'id_kategori'    => 4,
                'nama_pelaminan' => 'Kanopi Dekorasi',
                'jenis'          => 'Kanopi',
                'ukuran'         => '5x5 meter',
                'warna'          => 'Putih',
                'harga_sewa'     => 3000000,
                'stok'           => 4,
                'status'         => 'tersedia'
            ],
        ];

        $this->db->table('pelaminan')->insertBatch($data);
        echo "✅ PelaminanSeeder: " . count($data) . " item pelaminan berhasil ditambahkan\n";
    }
}
