<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\PenyewaanModel;
use App\Models\DetailPenyewaanModel;
use App\Models\PelangganModel;
use App\Models\PelaminanModel;
use Config\Database;

class Penyewaan extends BaseController
{
    protected $penyewaanModel;
    protected $detailModel;
    protected $pelangganModel;
    protected $pelaminanModel;

    public function __construct()
    {
        $this->penyewaanModel = new PenyewaanModel();
        $this->detailModel = new DetailPenyewaanModel();
        $this->pelangganModel = new PelangganModel();
        $this->pelaminanModel = new PelaminanModel();
    }

    public function index()
    {
        // Pelanggan hanya lihat miliknya
        if ($this->isPelanggan()) {
            $penyewaan = $this->penyewaanModel->getByPelanggan($this->session->get('pelanggan_id'));
        } else {
            $penyewaan = $this->penyewaanModel->getWithRelations();
        }

        $data = [
            'title' => 'Data Penyewaan',
            'penyewaan' => $penyewaan
        ];
        return view('transaksi/penyewaan/index', $data);
    }

    public function create()
    {
        // Admin, Petugas, dan Pelanggan bisa input
        $data = [
            'title' => 'Tambah Penyewaan',
            'pelanggan' => $this->pelangganModel->getWithUser(),
            'pelaminan' => $this->pelaminanModel->where('status', 'tersedia')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/penyewaan/form', $data);
    }

    public function store()
    {
        // ============================================
        // VALIDASI KETAT - PENYEWAAN
        // ============================================

        // 1. Validasi Dasar
        $rules = [
            'tanggal_sewa' => [
                'rules' => 'required|valid_date|tanggal_tidak_kemarin',
                'errors' => [
                    'required' => 'Tanggal sewa wajib diisi',
                    'valid_date' => 'Format tanggal sewa tidak valid',
                    'tanggal_tidak_kemarin' => 'Tanggal sewa tidak boleh sebelum hari ini'
                ]
            ],
            'tanggal_kembali' => [
                'rules' => 'required|valid_date|tanggal_setelah[tanggal_sewa]|durasi_maksimal[tanggal_sewa,7]',
                'errors' => [
                    'required' => 'Tanggal kembali wajib diisi',
                    'valid_date' => 'Format tanggal kembali tidak valid',
                    'tanggal_setelah' => 'Tanggal kembali harus setelah atau sama dengan tanggal sewa',
                    'durasi_maksimal' => 'Durasi sewa maksimal 7 hari'
                ]
            ],
            'alamat_acara' => [
                'rules' => 'required|min_length[10]|max_length[500]',
                'errors' => [
                    'required' => 'Alamat acara wajib diisi',
                    'min_length' => 'Alamat acara minimal 10 karakter',
                    'max_length' => 'Alamat acara maksimal 500 karakter'
                ]
            ],
            'catatan' => [
                'rules' => 'permit_empty|max_length[1000]',
                'errors' => [
                    'max_length' => 'Catatan maksimal 1000 karakter'
                ]
            ]
        ];

        // 2. Validasi Pelanggan (jika bukan pelanggan yang input)
        if (!$this->isPelanggan()) {
            $rules['id_pelanggan'] = [
                'rules' => 'required|numeric|pelanggan_exists',
                'errors' => [
                    'required' => 'Pelanggan wajib dipilih',
                    'numeric' => 'ID Pelanggan tidak valid',
                    'pelanggan_exists' => 'Pelanggan tidak ditemukan di database'
                ]
            ];
        }

        // Jalankan validasi dasar
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // 3. Validasi Detail Pelaminan
        $pelaminanIds = $this->request->getPost('pelaminan_id') ?? [];
        $jumlahs = $this->request->getPost('jumlah') ?? [];
        $tanggalSewa = $this->request->getPost('tanggal_sewa');
        $tanggalKembali = $this->request->getPost('tanggal_kembali');

        // Cek minimal ada 1 item
        $validItems = array_filter($pelaminanIds, fn($id) => !empty($id));
        if (empty($validItems)) {
            return redirect()->back()->withInput()->with('error', 'Minimal pilih 1 item pelaminan');
        }

        // 4. Validasi Ketersediaan Pelaminan (Cek Bentrok)
        $db = Database::connect();
        $bentrokItems = [];

        foreach ($pelaminanIds as $key => $idPelaminan) {
            if (empty($idPelaminan)) continue;

            // Cek apakah pelaminan ada
            $pelaminan = $this->pelaminanModel->find($idPelaminan);
            if (!$pelaminan) {
                return redirect()->back()->withInput()->with('error', "Pelaminan dengan ID {$idPelaminan} tidak ditemukan");
            }

            // Cek bentrok jadwal
            $bentrok = $db->table('detail_penyewaan dp')
                ->select('p.id_sewa, p.tanggal_sewa, p.tanggal_kembali')
                ->join('penyewaan p', 'p.id_sewa = dp.id_sewa')
                ->where('dp.id_pelaminan', $idPelaminan)
                ->whereNotIn('p.status_sewa', ['batal', 'selesai'])
                ->groupStart()
                ->where('p.tanggal_sewa <=', $tanggalKembali)
                ->where('p.tanggal_kembali >=', $tanggalSewa)
                ->groupEnd()
                ->get()
                ->getRowArray();

            if ($bentrok) {
                $bentrokItems[] = $pelaminan['nama_pelaminan'] . ' (sudah disewa ' . date('d/m/Y', strtotime($bentrok['tanggal_sewa'])) . ' - ' . date('d/m/Y', strtotime($bentrok['tanggal_kembali'])) . ')';
            }

            // Validasi jumlah
            $jumlah = (int)($jumlahs[$key] ?? 0);
            if ($jumlah < 1) {
                return redirect()->back()->withInput()->with('error', "Jumlah untuk {$pelaminan['nama_pelaminan']} harus minimal 1");
            }
        }

        if (!empty($bentrokItems)) {
            return redirect()->back()->withInput()->with('error', 'Pelaminan berikut tidak tersedia pada tanggal tersebut: ' . implode(', ', $bentrokItems));
        }

        // 5. Hitung Total dan Validasi Keuangan
        $totalBayar = 0;
        $detailData = [];

        foreach ($pelaminanIds as $key => $idPelaminan) {
            if (empty($idPelaminan) || empty($jumlahs[$key])) continue;

            $pelaminan = $this->pelaminanModel->find($idPelaminan);
            $jumlah = (int)$jumlahs[$key];
            $subtotal = $pelaminan['harga_sewa'] * $jumlah;
            $totalBayar += $subtotal;

            $detailData[] = [
                'id_pelaminan' => $idPelaminan,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal
            ];
        }

        // Validasi total harga
        if ($totalBayar <= 0) {
            return redirect()->back()->withInput()->with('error', 'Total harga harus lebih dari 0');
        }

        // 6. Validasi DP (jika ada)
        $dpBayar = (float)$this->request->getPost('dp_bayar');
        if ($dpBayar > 0) {
            // DP tidak boleh lebih dari total
            if ($dpBayar > $totalBayar) {
                return redirect()->back()->withInput()->with('error', 'DP tidak boleh lebih besar dari total harga (Rp ' . number_format($totalBayar, 0, ',', '.') . ')');
            }

            // Minimal DP 30%
            $minDp = $totalBayar * 0.3;
            if ($dpBayar < $minDp) {
                return redirect()->back()->withInput()->with('error', 'Minimal DP adalah 30% dari total (Rp ' . number_format($minDp, 0, ',', '.') . ')');
            }
        }

        // 7. Validasi User Aktif (petugas yang input)
        $userId = $this->session->get('user_id');
        $userAktif = $db->table('users')
            ->where('id_user', $userId)
            ->where('status', 'aktif')
            ->countAllResults();

        if (!$userAktif) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif, tidak dapat melakukan transaksi');
        }

        // ============================================
        // SIMPAN DATA
        // ============================================

        // Jika pelanggan, paksa id_pelanggan dari session
        $idPelanggan = $this->isPelanggan()
            ? $this->session->get('pelanggan_id')
            : $this->request->getPost('id_pelanggan');

        // Insert penyewaan
        $idSewa = $this->penyewaanModel->insert([
            'id_pelanggan'    => $idPelanggan,
            'tanggal_sewa'    => $tanggalSewa,
            'tanggal_kembali' => $tanggalKembali,
            'alamat_acara'    => $this->request->getPost('alamat_acara'),
            'catatan'         => $this->request->getPost('catatan'),
            'total_bayar'     => $totalBayar,
            'status_sewa'     => 'booking',
            'created_by'      => $userId
        ]);

        // Insert detail penyewaan
        foreach ($detailData as $detail) {
            $detail['id_sewa'] = $idSewa;
            $this->detailModel->insert($detail);

            // Update status pelaminan menjadi 'disewa'
            $this->pelaminanModel->update($detail['id_pelaminan'], ['status' => 'disewa']);
        }

        // Insert pembayaran DP jika ada
        if ($dpBayar > 0) {
            $db->table('pembayaran')->insert([
                'id_sewa' => $idSewa,
                'tanggal_bayar' => date('Y-m-d'),
                'jumlah_bayar' => $dpBayar,
                'metode_bayar' => $this->request->getPost('metode_bayar') ?? 'tunai',
                'keterangan' => 'DP Awal',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/transaksi/penyewaan')->with('success', 'Penyewaan berhasil ditambahkan dengan No. Nota #' . str_pad($idSewa, 5, '0', STR_PAD_LEFT));
    }

    public function detail($id)
    {
        $penyewaan = $this->penyewaanModel->getWithRelations($id);
        if (!$penyewaan) {
            return redirect()->to('/transaksi/penyewaan')->with('error', 'Data tidak ditemukan');
        }

        // Cek akses pelanggan
        if ($this->isPelanggan() && $penyewaan['id_pelanggan'] != $this->session->get('pelanggan_id')) {
            return $this->denyAccess();
        }

        $data = [
            'title' => 'Detail Penyewaan',
            'penyewaan' => $penyewaan,
            'detail' => $this->detailModel->getByPenyewaan($id)
        ];
        return view('transaksi/penyewaan/detail', $data);
    }

    public function edit($id)
    {
        if (!$this->hasRole([self::ROLE_ADMIN])) {
            return $this->denyAccess();
        }

        $penyewaan = $this->penyewaanModel->find($id);
        if (!$penyewaan) {
            return redirect()->to('/transaksi/penyewaan')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Penyewaan',
            'penyewaan' => $penyewaan,
            'pelanggan' => $this->pelangganModel->getWithUser(),
            'pelaminan' => $this->pelaminanModel->findAll(),
            'detail' => $this->detailModel->getByPenyewaan($id),
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/penyewaan/form', $data);
    }

    public function update($id)
    {
        if (!$this->hasRole([self::ROLE_ADMIN])) {
            return $this->denyAccess();
        }

        $rules = [
            'tanggal_sewa' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal sewa wajib diisi',
                    'valid_date' => 'Format tanggal sewa tidak valid'
                ]
            ],
            'tanggal_kembali' => [
                'rules' => 'required|valid_date|tanggal_setelah[tanggal_sewa]',
                'errors' => [
                    'required' => 'Tanggal kembali wajib diisi',
                    'valid_date' => 'Format tanggal kembali tidak valid',
                    'tanggal_setelah' => 'Tanggal kembali harus setelah atau sama dengan tanggal sewa'
                ]
            ],
            'status_sewa' => [
                'rules' => 'required|in_list[booking,berjalan,selesai,batal]',
                'errors' => [
                    'required' => 'Status wajib dipilih',
                    'in_list' => 'Status tidak valid'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $statusBaru = $this->request->getPost('status_sewa');
        $penyewaanLama = $this->penyewaanModel->find($id);

        $this->penyewaanModel->update($id, [
            'tanggal_sewa'    => $this->request->getPost('tanggal_sewa'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status_sewa'     => $statusBaru,
        ]);

        // Jika status berubah ke selesai/batal, kembalikan status pelaminan
        if (in_array($statusBaru, ['selesai', 'batal']) && !in_array($penyewaanLama['status_sewa'], ['selesai', 'batal'])) {
            $details = $this->detailModel->where('id_sewa', $id)->findAll();
            foreach ($details as $detail) {
                $this->pelaminanModel->update($detail['id_pelaminan'], ['status' => 'tersedia']);
            }
        }

        return redirect()->to('/transaksi/penyewaan')->with('success', 'Penyewaan berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->hasRole([self::ROLE_ADMIN])) {
            return $this->denyAccess();
        }

        $penyewaan = $this->penyewaanModel->find($id);
        if (!$penyewaan) {
            return redirect()->to('/transaksi/penyewaan')->with('error', 'Data tidak ditemukan');
        }

        // Kembalikan status pelaminan
        $details = $this->detailModel->where('id_sewa', $id)->findAll();
        foreach ($details as $detail) {
            $this->pelaminanModel->update($detail['id_pelaminan'], ['status' => 'tersedia']);
        }

        // Hapus detail dulu
        $this->detailModel->where('id_sewa', $id)->delete();
        $this->penyewaanModel->delete($id);

        return redirect()->to('/transaksi/penyewaan')->with('success', 'Penyewaan berhasil dihapus');
    }

    /**
     * Cetak Invoice/Nota Penyewaan
     */
    public function cetak($id)
    {
        $penyewaan = $this->penyewaanModel->getWithRelations($id);
        if (!$penyewaan) {
            return redirect()->to('/transaksi/penyewaan')->with('error', 'Data tidak ditemukan');
        }

        // Cek akses pelanggan
        if ($this->isPelanggan() && $penyewaan['id_pelanggan'] != $this->session->get('pelanggan_id')) {
            return $this->denyAccess();
        }

        // Ambil detail penyewaan dengan info pelaminan
        $db = Database::connect();
        $detail = $db->table('detail_penyewaan dp')
            ->select('dp.*, p.nama_pelaminan, p.jenis, p.warna, p.harga_sewa')
            ->join('pelaminan p', 'p.id_pelaminan = dp.id_pelaminan')
            ->where('dp.id_sewa', $id)
            ->get()
            ->getResultArray();

        // Ambil riwayat pembayaran
        $pembayaran = $db->table('pembayaran')
            ->where('id_sewa', $id)
            ->orderBy('tanggal_bayar', 'ASC')
            ->get()
            ->getResultArray();

        // Hitung total dibayar dan sisa
        $totalDibayar = array_sum(array_column($pembayaran, 'jumlah_bayar'));
        $sisaBayar = $penyewaan['total_bayar'] - $totalDibayar;

        $data = [
            'title' => 'Cetak Invoice',
            'penyewaan' => $penyewaan,
            'detail' => $detail,
            'pembayaran' => $pembayaran,
            'totalDibayar' => $totalDibayar,
            'sisaBayar' => $sisaBayar
        ];

        return view('transaksi/penyewaan/cetak_nota', $data);
    }
}
