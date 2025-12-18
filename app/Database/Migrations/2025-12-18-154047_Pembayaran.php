<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembayaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bayar' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_sewa' => [
                'type' => 'INT'
            ],
            'tanggal_bayar' => [
                'type' => 'DATE'
            ],
            'metode' => [
                'type' => 'ENUM',
                'constraint' => ['tunai', 'transfer']
            ],
            'jumlah_bayar' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2'
            ],
            'status_bayar' => [
                'type' => 'ENUM',
                'constraint' => ['lunas', 'belum'],
                'default' => 'belum'
            ],
        ]);

        $this->forge->addKey('id_bayar', true);
        $this->forge->addForeignKey('id_sewa', 'penyewaan', 'id_sewa');
        $this->forge->createTable('pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('pembayaran');
    }
}
