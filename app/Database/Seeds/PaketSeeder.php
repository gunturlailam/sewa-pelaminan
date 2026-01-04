<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PaketSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_paket'  => 'Paket Bronze',
                'deskripsi'   => 'Paket pelaminan sederhana untuk acara intimate. Termasuk dekorasi minimalis dan pelaminan standar.',
                'harga_paket' => 5000000,
                'status'      => 'aktif'
            ],
            [
                'nama_paket'  => 'Paket Silver',
                'deskripsi'   => 'Paket pelaminan menengah dengan dekorasi elegan. Termasuk backdrop, bunga segar, dan lighting standar.',
                'harga_paket' => 10000000,
                'status'      => 'aktif'
            ],
            [
                'nama_paket'  => 'Paket Gold',
                'deskripsi'   => 'Paket pelaminan premium dengan dekorasi mewah. Termasuk full decoration, bunga import, dan lighting premium.',
                'harga_paket' => 20000000,
                'status'      => 'aktif'
            ],
            [
                'nama_paket'  => 'Paket Platinum',
                'deskripsi'   => 'Paket pelaminan eksklusif all-in-one. Termasuk semua dekorasi, catering setup, dan dokumentasi area.',
                'harga_paket' => 35000000,
                'status'      => 'aktif'
            ],
            [
                'nama_paket'  => 'Paket Custom',
                'deskripsi'   => 'Paket pelaminan sesuai keinginan. Harga menyesuaikan dengan kebutuhan dan request khusus.',
                'harga_paket' => 15000000,
                'status'      => 'aktif'
            ],
        ];

        $this->db->table('paket_pelaminan')->insertBatch($data);
        echo "✅ PaketSeeder: " . count($data) . " paket berhasil ditambahkan\n";
    }
}
