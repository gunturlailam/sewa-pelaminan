<?php

namespace App\Models;

use CodeIgniter\Model;

class KeberangkatanModel extends Model
{
    protected $table = 'pemberangkatan';
    protected $primaryKey = 'id_pemberangkatan';
    protected $allowedFields = [
        'id_pemberangkatan',
        'id_bus',
        'id_karyawan',
        'id_pemesanan',
        'tanggal_berangkat',
        'tujuan',
        'status'
    ];

    public function getLaporanByTujuan($tujuan = null)
    {
        $builder = $this->db->table('pemberangkatan');
        $builder->select('pemberangkatan.*, bus.nama_bus, karyawan.nama as nama_karyawan, pemesanan.kode_pemesanan, pemesanan_detail.*, paket_bus.nama_paket as nama_paket_bus, paket_wisata.nama_paket as nama_paket_wisata');
        $builder->join('bus', 'bus.id_bus = pemberangkatan.id_bus', 'left');
        $builder->join('karyawan', 'karyawan.id_karyawan = pemberangkatan.id_karyawan', 'left');
        $builder->join('pemesanan', 'pemesanan.id_pemesanan = pemberangkatan.id_pemesanan', 'left');
        $builder->join('pemesanan_detail', 'pemesanan_detail.id_pemesanan = pemesanan.id_pemesanan', 'left');
        $builder->join('paket_bus', 'paket_bus.id_paket = pemesanan_detail.id_paket_bus', 'left');
        $builder->join('paket_wisata', 'paket_wisata.id_paket = pemesanan_detail.id_paket_wisata', 'left');
        if ($tujuan) {
            $builder->where('pemberangkatan.tujuan', $tujuan);
        }
        return $builder->get()->getResultArray();
    }
}
