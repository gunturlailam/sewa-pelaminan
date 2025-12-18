<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelaminan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pelaminan' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'nama_pelaminan' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'jenis' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'ukuran' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'warna' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'harga_sewa' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2'
            ],
            'stok' => [
                'type' => 'INT'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['tersedia', 'disewa'],
                'default' => 'tersedia'
            ],
        ]);

        $this->forge->addKey('id_pelaminan', true);
        $this->forge->createTable('pelaminan');
    }

    public function down()
    {
        $this->forge->dropTable('pelaminan');
    }
}
