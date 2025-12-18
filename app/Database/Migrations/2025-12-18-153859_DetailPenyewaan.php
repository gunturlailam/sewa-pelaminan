<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailPenyewaan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail_sewa' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_sewa' => [
                'type' => 'INT'
            ],
            'id_pelaminan' => [
                'type' => 'INT'
            ],
            'jumlah' => [
                'type' => 'INT'
            ],
            'subtotal' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2'
            ],
        ]);

        $this->forge->addKey('id_detail_sewa', true);
        $this->forge->addForeignKey('id_sewa', 'penyewaan', 'id_sewa');
        $this->forge->addForeignKey('id_pelaminan', 'pelaminan', 'id_pelaminan');
        $this->forge->createTable('detail_penyewaan');
    }

    public function down()
    {
        $this->forge->dropTable('detail_penyewaan');
    }
}
