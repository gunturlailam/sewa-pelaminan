<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengembalian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kembali' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_sewa' => [
                'type' => 'INT'
            ],
            'tanggal_kembali' => [
                'type' => 'DATE'
            ],
            'kondisi' => [
                'type' => 'ENUM',
                'constraint' => ['baik', 'rusak', 'hilang'],
                'default' => 'baik'
            ],
            'denda' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => 0
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);

        $this->forge->addKey('id_kembali', true);
        $this->forge->addForeignKey('id_sewa', 'penyewaan', 'id_sewa');
        $this->forge->createTable('pengembalian');
    }

    public function down()
    {
        $this->forge->dropTable('pengembalian');
    }
}
