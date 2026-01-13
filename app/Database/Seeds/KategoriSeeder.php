<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kategori' => 'Pelaminan Utama',
                'deskripsi'     => 'Set pelaminan lengkap khas Minangkabau untuk pengantin',
                'status'        => 'aktif'
            ],
            [
                'nama_kategori' => 'Dekorasi Ruangan',
                'deskripsi'     => 'Hiasan dan dekorasi pendukung acara adat Minang',
                'status'        => 'aktif'
            ],
            [
                'nama_kategori' => 'Perlengkapan Adat',
                'deskripsi'     => 'Perlengkapan upacara adat Minangkabau',
                'status'        => 'aktif'
            ],
            [
                'nama_kategori' => 'Tenda & Kanopi',
                'deskripsi'     => 'Tenda dan atap untuk acara outdoor',
                'status'        => 'aktif'
            ],
        ];

        $this->db->table('kategori')->insertBatch($data);
        echo "✅ KategoriSeeder: " . count($data) . " kategori berhasil ditambahkan\n";
    }
}
