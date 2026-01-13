<?php

namespace App\Models;

use CodeIgniter\Model;

class PelaminanModel extends Model
{
    protected $table            = 'pelaminan';
    protected $primaryKey       = 'id_pelaminan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_kategori', 'nama_pelaminan', 'jenis', 'ukuran', 'warna', 'harga_sewa', 'stok', 'status'];

    protected $validationRules = [
        'nama_pelaminan' => 'required|min_length[3]|max_length[100]',
        'jenis'          => 'required|max_length[50]',
        'ukuran'         => 'required|max_length[50]',
        'warna'          => 'required|max_length[50]',
        'harga_sewa'     => 'required|numeric',
        'stok'           => 'required|integer',
        'status'         => 'required|in_list[tersedia,disewa]',
    ];

    /**
     * Ambil pelaminan dengan nama kategori
     */
    public function getWithKategori($id = null)
    {
        $builder = $this->select('pelaminan.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = pelaminan.id_kategori', 'left');

        if ($id) {
            return $builder->where('pelaminan.id_pelaminan', $id)->first();
        }

        return $builder->orderBy('pelaminan.id_pelaminan', 'DESC')->findAll();
    }

    /**
     * Ambil pelaminan yang tersedia untuk disewa (tidak sedang booking/berjalan)
     */
    public function getAvailableForRent()
    {
        $db = \Config\Database::connect();

        // Ambil ID pelaminan yang sedang disewa (status booking atau berjalan)
        $sedangDisewa = $db->table('penyewaan')
            ->select('id_pelaminan')
            ->whereIn('status_sewa', ['booking', 'berjalan'])
            ->get()
            ->getResultArray();

        $idSedangDisewa = array_column($sedangDisewa, 'id_pelaminan');

        $builder = $this->select('pelaminan.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = pelaminan.id_kategori', 'left')
            ->where('pelaminan.status', 'tersedia');

        // Exclude pelaminan yang sedang disewa
        if (!empty($idSedangDisewa)) {
            $builder->whereNotIn('pelaminan.id_pelaminan', $idSedangDisewa);
        }

        return $builder->orderBy('kategori.nama_kategori', 'ASC')
            ->orderBy('pelaminan.nama_pelaminan', 'ASC')
            ->findAll();
    }
}
