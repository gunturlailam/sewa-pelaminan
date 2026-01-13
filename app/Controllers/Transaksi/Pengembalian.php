<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\PengembalianModel;
use App\Models\PenyewaanModel;
use App\Models\PelaminanModel;

class Pengembalian extends BaseController
{
    protected $pengembalianModel;
    protected $penyewaanModel;
    protected $pelaminanModel;

    public function __construct()
    {
        $this->pengembalianModel = new PengembalianModel();
        $this->penyewaanModel = new PenyewaanModel();
        $this->pelaminanModel = new PelaminanModel();
    }

    public function index()
    {
        if ($this->isPelanggan()) {
            $pengembalian = $this->pengembalianModel->getByPelanggan($this->session->get('pelanggan_id'));
        } else {
            $pengembalian = $this->pengembalianModel->getWithRelations();
        }

        $data = [
            'title' => 'Data Pengembalian',
            'pengembalian' => $pengembalian
        ];
        return view('transaksi/pengembalian/index', $data);
    }

    public function create()
    {
        if (!$this->canInputTransaksi()) {
            return $this->denyAccess();
        }

        // Ambil penyewaan yang belum dikembalikan (status booking atau berjalan)
        $penyewaan = $this->penyewaanModel->getPenyewaanBelumKembali();

        $data = [
            'title' => 'Proses Pengembalian',
            'penyewaan' => $penyewaan,
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/pengembalian/form', $data);
    }

    public function store()
    {
        if (!$this->canInputTransaksi()) {
            return $this->denyAccess();
        }

        // ============================================
        // VALIDASI KETAT - PENGEMBALIAN
        // ============================================

        $rules = [
            'id_sewa' => [
                'rules' => 'required|numeric|penyewaan_exists|penyewaan_belum_kembali',
                'errors' => [
                    'required' => 'Penyewaan wajib dipilih',
                    'numeric' => 'ID Penyewaan tidak valid',
                    'penyewaan_exists' => 'Data penyewaan tidak ditemukan',
                    'penyewaan_belum_kembali' => 'Penyewaan ini sudah dikembalikan'
                ]
            ],
            'tanggal_kembali' => [
                'rules' => 'required|valid_date|tanggal_kembali_valid[id_sewa]',
                'errors' => [
                    'required' => 'Tanggal kembali wajib diisi',
                    'valid_date' => 'Format tanggal tidak valid',
                    'tanggal_kembali_valid' => 'Tanggal kembali tidak boleh sebelum tanggal sewa'
                ]
            ],
            'kondisi' => [
                'rules' => 'required|in_list[baik,rusak,hilang]',
                'errors' => [
                    'required' => 'Kondisi barang wajib dipilih',
                    'in_list' => 'Kondisi tidak valid'
                ]
            ],
            'denda' => [
                'rules' => 'permit_empty|numeric|greater_than_equal_to[0]',
                'errors' => [
                    'numeric' => 'Denda harus berupa angka',
                    'greater_than_equal_to' => 'Denda tidak boleh negatif'
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
        $kondisi = $this->request->getPost('kondisi');
        $denda = (float) ($this->request->getPost('denda') ?? 0);

        // Validasi tambahan
        $penyewaan = $this->penyewaanModel->find($idSewa);
        if (!$penyewaan) {
            return redirect()->back()->withInput()->with('error', 'Data penyewaan tidak ditemukan');
        }

        // Cek apakah sudah ada pengembalian
        $existingKembali = $this->pengembalianModel->where('id_sewa', $idSewa)->first();
        if ($existingKembali) {
            return redirect()->back()->withInput()->with('error', 'Penyewaan ini sudah dikembalikan sebelumnya');
        }

        // Hitung keterlambatan
        $tanggalKembali = $this->request->getPost('tanggal_kembali');
        $jadwalKembali = $penyewaan['tanggal_kembali'];
        $hariTerlambat = 0;

        if (strtotime($tanggalKembali) > strtotime($jadwalKembali)) {
            $hariTerlambat = ceil((strtotime($tanggalKembali) - strtotime($jadwalKembali)) / (60 * 60 * 24));
        }

        $this->pengembalianModel->insert([
            'id_sewa'         => $idSewa,
            'tanggal_kembali' => $tanggalKembali,
            'kondisi'         => $kondisi,
            'denda'           => $denda,
            'keterangan'      => $this->request->getPost('keterangan'),
            'created_at'      => date('Y-m-d H:i:s')
        ]);

        // Update status penyewaan
        $this->penyewaanModel->update($idSewa, ['status_sewa' => 'selesai']);

        // Kembalikan status pelaminan menjadi tersedia (1 penyewaan = 1 pelaminan)
        if (!empty($penyewaan['id_pelaminan'])) {
            $this->pelaminanModel->update($penyewaan['id_pelaminan'], ['status' => 'tersedia']);
        }

        // Buat pesan sukses dengan detail
        $message = 'Pengembalian berhasil diproses';
        $details = [];

        if ($hariTerlambat > 0) {
            $details[] = 'Terlambat ' . $hariTerlambat . ' hari';
        }

        if ($kondisi === 'rusak') {
            $details[] = 'Kondisi rusak';
        } elseif ($kondisi === 'hilang') {
            $details[] = 'Barang hilang';
        }

        if ($denda > 0) {
            $details[] = 'Total denda: Rp ' . number_format($denda, 0, ',', '.');
        }

        if (!empty($details)) {
            $message .= ' (' . implode(', ', $details) . ')';
        }

        return redirect()->to('/transaksi/pengembalian')->with('success', $message);
    }

    public function edit($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $pengembalian = $this->pengembalianModel->find($id);
        if (!$pengembalian) {
            return redirect()->to('/transaksi/pengembalian')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pengembalian',
            'pengembalian' => $pengembalian,
            'penyewaan' => $this->penyewaanModel->getWithRelations(),
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/pengembalian/form', $data);
    }

    public function update($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $rules = [
            'tanggal_kembali' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal kembali wajib diisi',
                    'valid_date' => 'Format tanggal tidak valid'
                ]
            ],
            'kondisi' => [
                'rules' => 'required|in_list[baik,rusak,hilang]',
                'errors' => [
                    'required' => 'Kondisi barang wajib dipilih',
                    'in_list' => 'Kondisi tidak valid'
                ]
            ],
            'denda' => [
                'rules' => 'permit_empty|numeric|greater_than_equal_to[0]',
                'errors' => [
                    'numeric' => 'Denda harus berupa angka',
                    'greater_than_equal_to' => 'Denda tidak boleh negatif'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->pengembalianModel->update($id, [
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'kondisi'         => $this->request->getPost('kondisi'),
            'denda'           => $this->request->getPost('denda') ?? 0,
            'keterangan'      => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/transaksi/pengembalian')->with('success', 'Pengembalian berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $pengembalian = $this->pengembalianModel->find($id);
        if (!$pengembalian) {
            return redirect()->to('/transaksi/pengembalian')->with('error', 'Data tidak ditemukan');
        }

        // Ambil data penyewaan untuk mendapatkan id_pelaminan
        $penyewaan = $this->penyewaanModel->find($pengembalian['id_sewa']);

        // Kembalikan status penyewaan
        $this->penyewaanModel->update($pengembalian['id_sewa'], ['status_sewa' => 'berjalan']);

        // Kembalikan status pelaminan menjadi disewa (1 penyewaan = 1 pelaminan)
        if ($penyewaan && !empty($penyewaan['id_pelaminan'])) {
            $this->pelaminanModel->update($penyewaan['id_pelaminan'], ['status' => 'disewa']);
        }

        $this->pengembalianModel->delete($id);

        return redirect()->to('/transaksi/pengembalian')->with('success', 'Pengembalian berhasil dihapus');
    }
}
