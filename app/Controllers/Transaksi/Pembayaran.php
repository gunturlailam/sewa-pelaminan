<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\PenyewaanModel;
use Config\Database;

class Pembayaran extends BaseController
{
    protected $pembayaranModel;
    protected $penyewaanModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->penyewaanModel = new PenyewaanModel();
    }

    public function index()
    {
        if ($this->isPelanggan()) {
            $pembayaran = $this->pembayaranModel->getByPelanggan($this->session->get('pelanggan_id'));
        } else {
            $pembayaran = $this->pembayaranModel->getWithRelations();
        }

        $data = [
            'title' => 'Data Pembayaran',
            'pembayaran' => $pembayaran
        ];
        return view('transaksi/pembayaran/index', $data);
    }

    public function create()
    {
        if (!$this->canInputTransaksi()) {
            return $this->denyAccess();
        }

        // Ambil penyewaan yang belum lunas
        $penyewaan = $this->penyewaanModel->getPenyewaanBelumLunas();

        $data = [
            'title' => 'Tambah Pembayaran',
            'penyewaan' => $penyewaan,
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/pembayaran/form', $data);
    }

    public function store()
    {
        if (!$this->canInputTransaksi()) {
            return $this->denyAccess();
        }

        // ============================================
        // VALIDASI KETAT - PEMBAYARAN
        // ============================================

        $rules = [
            'id_sewa' => [
                'rules' => 'required|numeric|penyewaan_exists|penyewaan_belum_lunas',
                'errors' => [
                    'required' => 'Penyewaan wajib dipilih',
                    'numeric' => 'ID Penyewaan tidak valid',
                    'penyewaan_exists' => 'Data penyewaan tidak ditemukan',
                    'penyewaan_belum_lunas' => 'Penyewaan ini sudah lunas'
                ]
            ],
            'tanggal_bayar' => [
                'rules' => 'required|valid_date|tanggal_bayar_valid',
                'errors' => [
                    'required' => 'Tanggal bayar wajib diisi',
                    'valid_date' => 'Format tanggal tidak valid',
                    'tanggal_bayar_valid' => 'Tanggal bayar tidak boleh lebih dari hari ini'
                ]
            ],
            'metode_bayar' => [
                'rules' => 'required|in_list[tunai]',
                'errors' => [
                    'required' => 'Metode pembayaran wajib dipilih',
                    'in_list' => 'Metode pembayaran tidak valid'
                ]
            ],
            'jumlah_bayar' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Jumlah bayar wajib diisi',
                    'numeric' => 'Jumlah bayar harus berupa angka',
                    'greater_than' => 'Jumlah bayar harus lebih dari 0'
                ]
            ],
            'keterangan' => [
                'rules' => 'permit_empty|max_length[500]',
                'errors' => [
                    'max_length' => 'Keterangan maksimal 500 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $idSewa = $this->request->getPost('id_sewa');
        $jumlahBayar = (float) $this->request->getPost('jumlah_bayar');

        // Validasi tambahan: cek sisa tagihan
        $penyewaan = $this->penyewaanModel->find($idSewa);
        if (!$penyewaan) {
            return redirect()->back()->withInput()->with('error', 'Data penyewaan tidak ditemukan');
        }

        // Cek status penyewaan
        if ($penyewaan['status_sewa'] === 'batal') {
            return redirect()->back()->withInput()->with('error', 'Tidak dapat membayar penyewaan yang sudah dibatalkan');
        }

        $totalDibayar = $this->pembayaranModel->getTotalBayar($idSewa);
        $sisaBayar = $penyewaan['total_bayar'] - $totalDibayar;

        // Validasi jumlah bayar tidak melebihi sisa
        if ($jumlahBayar > $sisaBayar) {
            return redirect()->back()->withInput()->with('error', 'Jumlah bayar (Rp ' . number_format($jumlahBayar, 0, ',', '.') . ') melebihi sisa tagihan (Rp ' . number_format($sisaBayar, 0, ',', '.') . ')');
        }

        $this->pembayaranModel->insert([
            'id_sewa'       => $idSewa,
            'tanggal_bayar' => $this->request->getPost('tanggal_bayar'),
            'metode_bayar'  => 'tunai',
            'jumlah_bayar'  => $jumlahBayar,
            'keterangan'    => $this->request->getPost('keterangan'),
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        $message = 'Pembayaran berhasil ditambahkan';
        $sisaBaru = $sisaBayar - $jumlahBayar;
        if ($sisaBaru <= 0) {
            $message .= '. Status: LUNAS';
        } else {
            $message .= '. Sisa tagihan: Rp ' . number_format($sisaBaru, 0, ',', '.');
        }

        return redirect()->to('/transaksi/pembayaran')->with('success', $message);
    }

    public function edit($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $pembayaran = $this->pembayaranModel->find($id);
        if (!$pembayaran) {
            return redirect()->to('/transaksi/pembayaran')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pembayaran',
            'pembayaran' => $pembayaran,
            'penyewaan' => $this->penyewaanModel->getWithRelations(),
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/pembayaran/form', $data);
    }

    public function update($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $pembayaranLama = $this->pembayaranModel->find($id);
        if (!$pembayaranLama) {
            return redirect()->to('/transaksi/pembayaran')->with('error', 'Data tidak ditemukan');
        }

        $rules = [
            'tanggal_bayar' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal bayar wajib diisi',
                    'valid_date' => 'Format tanggal tidak valid'
                ]
            ],
            'metode_bayar' => [
                'rules' => 'required|in_list[tunai]',
                'errors' => [
                    'required' => 'Metode pembayaran wajib dipilih',
                    'in_list' => 'Metode pembayaran tidak valid'
                ]
            ],
            'jumlah_bayar' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Jumlah bayar wajib diisi',
                    'numeric' => 'Jumlah bayar harus berupa angka',
                    'greater_than' => 'Jumlah bayar harus lebih dari 0'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $jumlahBayar = (float) $this->request->getPost('jumlah_bayar');
        $idSewa = $pembayaranLama['id_sewa'];

        // Validasi jumlah bayar tidak melebihi total + pembayaran lain
        $penyewaan = $this->penyewaanModel->find($idSewa);
        $totalDibayarLain = $this->pembayaranModel
            ->where('id_sewa', $idSewa)
            ->where('id_bayar !=', $id)
            ->selectSum('jumlah_bayar')
            ->first()['jumlah_bayar'] ?? 0;

        $maksimalBayar = $penyewaan['total_bayar'] - $totalDibayarLain;

        if ($jumlahBayar > $maksimalBayar) {
            return redirect()->back()->withInput()->with('error', 'Jumlah bayar melebihi sisa tagihan (Rp ' . number_format($maksimalBayar, 0, ',', '.') . ')');
        }

        $this->pembayaranModel->update($id, [
            'tanggal_bayar' => $this->request->getPost('tanggal_bayar'),
            'metode_bayar'  => 'tunai',
            'jumlah_bayar'  => $jumlahBayar,
            'keterangan'    => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/transaksi/pembayaran')->with('success', 'Pembayaran berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $pembayaran = $this->pembayaranModel->find($id);
        if (!$pembayaran) {
            return redirect()->to('/transaksi/pembayaran')->with('error', 'Data tidak ditemukan');
        }

        $this->pembayaranModel->delete($id);
        return redirect()->to('/transaksi/pembayaran')->with('success', 'Pembayaran berhasil dihapus');
    }
}
