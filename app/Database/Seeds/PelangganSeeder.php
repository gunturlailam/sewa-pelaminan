<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        // Pelanggan terhubung ke users via id_user
        // User pelanggan sudah dibuat di UserSeeder dengan id_user = 3
        $data = [
            [
                'id_user'       => 3, // user pelanggan dari UserSeeder
                'nik'           => '1371010101900001',
                'email'         => 'pelanggan@email.com',
                'tanggal_daftar' => date('Y-m-d')
            ],
        ];

        $this->db->table('pelanggan')->insertBatch($data);
        echo "✅ PelangganSeeder: " . count($data) . " pelanggan berhasil ditambahkan\n";
    }
}
