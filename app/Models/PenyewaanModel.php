<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyewaanModel extends Model
{
    protected $table            = 'penyewaan';
    protected $primaryKey       = 'id_sewa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_pelanggan', 'id_pelaminan', 'tanggal_sewa', 'tanggal_kembali', 'alamat_acara', 'catatan', 'harga_sewa', 'total_bayar', 'status_sewa', 'created_by'];

    public function getWithRelations($id = null)
    {
        $builder = $this->select('penyewaan.*, pelanggan.nik, users.nama as nama_pelanggan, users.no_hp, pelaminan.nama_pelaminan, pelaminan.jenis, pelaminan.warna')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->join('pelaminan', 'pelaminan.id_pelaminan = penyewaan.id_pelaminan');

        if ($id) {
            return $builder->where('penyewaan.id_sewa', $id)->first();
        }
        return $builder->orderBy('penyewaan.id_sewa', 'DESC')->findAll();
    }

    public function getByPelanggan($idPelanggan)
    {
        return $this->select('penyewaan.*, pelanggan.nik, users.nama as nama_pelanggan, pelaminan.nama_pelaminan, pelaminan.jenis, pelaminan.warna')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->join('pelaminan', 'pelaminan.id_pelaminan = penyewaan.id_pelaminan')
            ->where('penyewaan.id_pelanggan', $idPelanggan)
            ->orderBy('penyewaan.id_sewa', 'DESC')
            ->findAll();
    }

    /**
     * Ambil penyewaan yang belum lunas (masih ada sisa tagihan)
     */
    public function getPenyewaanBelumLunas()
    {
        $db = \Config\Database::connect();

        return $db->table('penyewaan p')
            ->select('p.*, u.nama as nama_pelanggan, pel.nik,
                      COALESCE((SELECT SUM(jumlah_bayar) FROM pembayaran WHERE id_sewa = p.id_sewa), 0) as total_dibayar')
            ->join('pelanggan pel', 'pel.id_pelanggan = p.id_pelanggan')
            ->join('users u', 'u.id_user = pel.id_user')
            ->where('p.status_sewa !=', 'batal')
            ->having('(p.total_bayar - total_dibayar) >', 0)
            ->orderBy('p.id_sewa', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil penyewaan yang belum dikembalikan (status booking atau berjalan)
     */
    public function getPenyewaanBelumKembali()
    {
        $db = \Config\Database::connect();

        return $db->table('penyewaan p')
            ->select('p.*, u.nama as nama_pelanggan, pel.nik')
            ->join('pelanggan pel', 'pel.id_pelanggan = p.id_pelanggan')
            ->join('users u', 'u.id_user = pel.id_user')
            ->whereIn('p.status_sewa', ['booking', 'berjalan'])
            ->whereNotIn('p.id_sewa', function ($builder) {
                return $builder->select('id_sewa')->from('pengembalian');
            })
            ->orderBy('p.id_sewa', 'DESC')
            ->get()
            ->getResultArray();
    }
}
