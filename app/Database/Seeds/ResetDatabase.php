<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResetDatabase extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();

        echo "🔄 Memulai reset database...\n\n";

        // Disable foreign key checks
        $db->query('SET FOREIGN_KEY_CHECKS = 0');

        // Daftar tabel yang akan di-drop (urutan tidak penting karena FK disabled)
        $tables = [
            'pengembalian',
            'pembayaran',
            'detail_penyewaan',
            'penyewaan',
            'pelaminan',
            'pelanggan',
            'kategori',
            'users',
            'migrations'
        ];

        foreach ($tables as $table) {
            if ($db->tableExists($table)) {
                $forge->dropTable($table, true);
                echo "✅ Tabel '{$table}' berhasil dihapus\n";
            } else {
                echo "⏭️  Tabel '{$table}' tidak ada, skip\n";
            }
        }

        // Enable foreign key checks
        $db->query('SET FOREIGN_KEY_CHECKS = 1');

        echo "\n✅ Reset database selesai!\n";
        echo "📝 Jalankan: php spark migrate && php spark db:seed MainSeeder\n";
    }
}
