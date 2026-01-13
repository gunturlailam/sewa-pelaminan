<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Data Users - Hanya 3 akun dasar
        $users = [
            [
                'nama'     => 'Administrator',
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'foto'     => 'default.png',
                'no_hp'    => '081234567890',
                'alamat'   => 'Jl. Admin No. 1, Kota',
                'status'   => 'aktif',
            ],
            [
                'nama'     => 'Petugas',
                'username' => 'petugas',
                'password' => password_hash('petugas123', PASSWORD_DEFAULT),
                'role'     => 'petugas',
                'foto'     => 'default.png',
                'no_hp'    => '081234567891',
                'alamat'   => 'Jl. Petugas No. 1, Kota',
                'status'   => 'aktif',
            ],
            [
                'nama'     => 'Pelanggan',
                'username' => 'pelanggan',
                'password' => password_hash('pelanggan123', PASSWORD_DEFAULT),
                'role'     => 'pelanggan',
                'foto'     => 'default.png',
                'no_hp'    => '081234567892',
                'alamat'   => 'Jl. Pelanggan No. 1, Kota',
                'status'   => 'aktif',
            ],
        ];

        $this->db->table('users')->insertBatch($users);

        // Ambil ID user pelanggan untuk tabel pelanggan
        $userPelanggan = $this->db->table('users')->where('username', 'pelanggan')->get()->getRow();

        // Data Pelanggan - link ke user pelanggan
        if ($userPelanggan) {
            $pelanggan = [
                'id_user' => $userPelanggan->id_user,
                'nik'     => '3201234567890001',
            ];
            $this->db->table('pelanggan')->insert($pelanggan);
        }

        echo "✅ UserSeeder: 3 user berhasil ditambahkan\n";
        echo "   ├─ admin / admin123 (Admin)\n";
        echo "   ├─ petugas / petugas123 (Petugas)\n";
        echo "   └─ pelanggan / pelanggan123 (Pelanggan)\n";
    }
}
