<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        // Buat user pelanggan dulu
        $users = [
            [
                'nama'     => 'Budi Santoso',
                'username' => 'budi',
                'password' => password_hash('budi123', PASSWORD_DEFAULT),
                'role'     => 'pelanggan',
                'foto'     => 'default.png',
                'no_hp'    => '081234567001',
                'alamat'   => 'Jl. Melati No. 10, Jakarta Selatan',
                'status'   => 'aktif'
            ],
            [
                'nama'     => 'Siti Rahayu',
                'username' => 'siti',
                'password' => password_hash('siti123', PASSWORD_DEFAULT),
                'role'     => 'pelanggan',
                'foto'     => 'default.png',
                'no_hp'    => '081234567002',
                'alamat'   => 'Jl. Mawar No. 25, Bandung',
                'status'   => 'aktif'
            ],
            [
                'nama'     => 'Ahmad Wijaya',
                'username' => 'ahmad',
                'password' => password_hash('ahmad123', PASSWORD_DEFAULT),
                'role'     => 'pelanggan',
                'foto'     => 'default.png',
                'no_hp'    => '081234567003',
                'alamat'   => 'Jl. Anggrek No. 5, Surabaya',
                'status'   => 'aktif'
            ],
            [
                'nama'     => 'Dewi Lestari',
                'username' => 'dewi',
                'password' => password_hash('dewi123', PASSWORD_DEFAULT),
                'role'     => 'pelanggan',
                'foto'     => 'default.png',
                'no_hp'    => '081234567004',
                'alamat'   => 'Jl. Kenanga No. 15, Yogyakarta',
                'status'   => 'aktif'
            ],
            [
                'nama'     => 'Rudi Hermawan',
                'username' => 'rudi',
                'password' => password_hash('rudi123', PASSWORD_DEFAULT),
                'role'     => 'pelanggan',
                'foto'     => 'default.png',
                'no_hp'    => '081234567005',
                'alamat'   => 'Jl. Dahlia No. 8, Semarang',
                'status'   => 'aktif'
            ],
        ];

        // Insert users dan simpan ID
        $userIds = [];
        foreach ($users as $user) {
            $this->db->table('users')->insert($user);
            $userIds[] = $this->db->insertID();
        }

        // Buat data pelanggan
        $pelanggan = [
            [
                'id_user'        => $userIds[0],
                'nik'            => '3201010101900001',
                'email'          => 'budi.santoso@email.com',
                'tanggal_daftar' => '2025-01-15'
            ],
            [
                'id_user'        => $userIds[1],
                'nik'            => '3201010101900002',
                'email'          => 'siti.rahayu@email.com',
                'tanggal_daftar' => '2025-02-20'
            ],
            [
                'id_user'        => $userIds[2],
                'nik'            => '3201010101900003',
                'email'          => 'ahmad.wijaya@email.com',
                'tanggal_daftar' => '2025-03-10'
            ],
            [
                'id_user'        => $userIds[3],
                'nik'            => '3201010101900004',
                'email'          => 'dewi.lestari@email.com',
                'tanggal_daftar' => '2025-04-05'
            ],
            [
                'id_user'        => $userIds[4],
                'nik'            => '3201010101900005',
                'email'          => 'rudi.hermawan@email.com',
                'tanggal_daftar' => '2025-05-12'
            ],
        ];

        $this->db->table('pelanggan')->insertBatch($pelanggan);
        echo "✅ PelangganSeeder: " . count($pelanggan) . " pelanggan berhasil ditambahkan\n";
    }
}
