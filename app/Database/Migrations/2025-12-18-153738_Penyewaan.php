<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penyewaan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sewa' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_pelanggan' => [
                'type' => 'INT'
            ],
            'tanggal_sewa' => [
                'type' => 'DATE'
            ],
            'tanggal_kembali' => [
                'type' => 'DATE'
            ],
            'total_bayar' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2'
            ],
            'status_sewa' => [
                'type' => 'ENUM',
                'constraint' => ['booking', 'berjalan', 'selesai', 'batal'],
                'default' => 'booking'
            ],
        ]);

        $this->forge->addKey('id_sewa', true);
        $this->forge->addForeignKey('id_pelanggan', 'pelanggan', 'id_pelanggan');
        $this->forge->createTable('penyewaan');
    }

    public function down()
    {
        $this->forge->dropTable('penyewaan');
    }
}
