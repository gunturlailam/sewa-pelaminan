<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaketPelaminan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_paket' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'nama_paket' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'deskripsi' => [
                'type' => 'TEXT'
            ],
            'harga_paket' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
                'default' => 'aktif'
            ],
        ]);

        $this->forge->addKey('id_paket', true);
        $this->forge->createTable('paket_pelaminan');
    }

    public function down()
    {
        $this->forge->dropTable('paket_pelaminan');
    }
}
