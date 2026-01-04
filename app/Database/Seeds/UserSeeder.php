<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Admin
            [
                'nama'     => 'Administrator',
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'foto'     => 'default.png',
                'no_hp'    => '081234567890',
                'alamat'   => 'Jl. Admin No. 1, Jakarta',
                'status'   => 'aktif'
            ],
            // Petugas
            [
                'nama'     => 'Petugas Satu',
                'username' => 'petugas',
                'password' => password_hash('petugas123', PASSWORD_DEFAULT),
                'role'     => 'petugas',
                'foto'     => 'default.png',
                'no_hp'    => '081234567891',
                'alamat'   => 'Jl. Petugas No. 1, Jakarta',
                'status'   => 'aktif'
            ],
            // Petugas 2
            [
                'nama'     => 'Petugas Dua',
                'username' => 'petugas2',
                'password' => password_hash('petugas123', PASSWORD_DEFAULT),
                'role'     => 'petugas',
                'foto'     => 'default.png',
                'no_hp'    => '081234567892',
                'alamat'   => 'Jl. Petugas No. 2, Jakarta',
                'status'   => 'aktif'
            ],
        ];

        $this->db->table('users')->insertBatch($data);

        echo "✅ UserSeeder: 3 user (Admin & Petugas) berhasil ditambahkan\n";
        echo "   ├─ admin / admin123\n";
        echo "   ├─ petugas / petugas123\n";
        echo "   └─ petugas2 / petugas123\n";
    }
}
