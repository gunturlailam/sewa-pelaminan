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
            'id_pelaminan' => [
                'type' => 'INT'
            ],
            'tanggal_sewa' => [
                'type' => 'DATE'
            ],
            'tanggal_kembali' => [
                'type' => 'DATE'
            ],
            'alamat_acara' => [
                'type' => 'TEXT'
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'harga_sewa' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2'
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
            'created_by' => [
                'type' => 'INT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);

        $this->forge->addKey('id_sewa', true);
        $this->forge->addForeignKey('id_pelanggan', 'pelanggan', 'id_pelanggan');
        $this->forge->addForeignKey('id_pelaminan', 'pelaminan', 'id_pelaminan');
        $this->forge->addForeignKey('created_by', 'users', 'id_user', 'SET NULL', 'SET NULL');
        $this->forge->createTable('penyewaan');
    }

    public function down()
    {
        $this->forge->dropTable('penyewaan');
    }
}
