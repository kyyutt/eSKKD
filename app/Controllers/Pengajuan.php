<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\UserModel;
use App\Models\PendaftaranSKKDModel;
use App\Models\DokterModel;
use App\Models\SKKDModel;

class Pengajuan extends BaseController
{
    protected $pasien;
    protected $user;
    protected $pendaftaran_skkd;
    protected $dokter;
    protected $skkd;

    public function __construct()
    {
        $this->pasien = new PasienModel();
        $this->user   = new UserModel();
        $this->pendaftaran_skkd = new PendaftaranSKKDModel();
        $this->dokter = new DokterModel();
        $this->skkd   = new SKKDModel();
    }

    /**
     * =========================
     * PAGE (Tampilan Utama)
     * =========================
     */
    public function index()
    {
        if (session()->get('role') == 'Admin') {
            $titleAdmin = 'Manajemen Riwayat Pendaftaran SKKD';
            $subtitleAdmin = 'Kelola riwayat pendaftaran SKKD di sini';
        } else {
            $titleAdmin = 'Riwayat Pendaftaran SKKD';
            $subtitleAdmin = 'Lihat riwayat pendaftaran SKKD Anda di sini';
        }
        $data = [
            'title'    => $titleAdmin,
            'subtitle' => $subtitleAdmin,
            'pasien'   => $this->pasien->findAll(),
            'dokter'   => $this->dokter->findAll(),
        ];
        return view('riwayat_pendaftaran/index', $data);
    }

    /**
     * =========================
     * AJAX LIST (TABLE + PAGINATION + SEARCH)
     * =========================
     */
    public function ajaxList()
    {
        $page   = (int) ($this->request->getGet('page') ?? 1);
        $limit  = (int) ($this->request->getGet('limit') ?? 10);
        $search = $this->request->getGet('search');
        $offset = ($page - 1) * $limit;

        // 1. Ganti builder ke tabel PENDAFTARAN
        $builder = $this->pendaftaran_skkd;

        // 2. Select data pendaftaran + Nama Pasien + Nama Dokter
        $builder->select('pendaftaran_skkd.*, pasien.nama_lengkap as nama_pasien, pasien.nik, dokter.nama_dokter');

        // 3. JOIN Tabel (PENTING!)
        // Join Pasien biar bisa cari berdasarkan Nama Pasien
        $builder->join('pasien', 'pasien.id_pasien = pendaftaran_skkd.id_pasien');
        // Join Dokter (Left Join, jaga-jaga kalau dokternya belum diisi/dihapus)
        $builder->join('dokter', 'dokter.id_dokter = pendaftaran_skkd.id_dokter', 'left');

        // 4. Logika Pencarian
        if ($search) {
            // Kita cari di tabel Pasien (Nama/NIK) dan Tabel Dokter
            $kolomPencarian = [
                'pasien.nama_lengkap',
                'pasien.nik',
                'dokter.nama_dokter',
                'pendaftaran_skkd.keperluan_surat'
            ];

            $builder->groupStart();
            foreach ($kolomPencarian as $k) {
                $builder->orLike($k, $search);
            }
            $builder->groupEnd();
        }

        // Hitung total data (setelah filter search)
        $total = $builder->countAllResults(false);

        // Ambil Data
        $data = $builder
            ->orderBy('pendaftaran_skkd.id_pendaftaran', 'DESC') // Urutkan dari yang terbaru
            ->findAll($limit, $offset);

        return $this->response->setJSON([
            'data' => $data,
            'pagination' => [
                'total'      => $total,
                'page'       => $page,
                'limit'      => $limit,
                'total_page' => ceil($total / $limit),
                'from'       => $total ? $offset + 1 : 0,
                'to'         => min($offset + $limit, $total),
            ],
        ]);
    }

    /**
     * =========================
     * DETAIL (SHOW)
     * =========================
     */
    public function show($id)
    {
        // Builder khusus untuk detail
        $builder = $this->pendaftaran_skkd;

        // Select lengkap termasuk nama pembuat/pengedit
        $builder->select('
            pendaftaran_skkd.*, 
            pasien.nama_lengkap as nama_pasien, pasien.nik, pasien.alamat,
            dokter.nama_dokter,
            creator.nama_lengkap as nama_pembuat,
            editor.nama_lengkap as nama_pengedit
        ');

        // Join tabel-tabel terkait
        $builder->join('pasien', 'pasien.id_pasien = pendaftaran_skkd.id_pasien');
        $builder->join('dokter', 'dokter.id_dokter = pendaftaran_skkd.id_dokter', 'left');

        // Join ke User untuk Audit Trail
        $builder->join('users as creator', 'creator.id_user = pendaftaran_skkd.created_by', 'left');
        $builder->join('users as editor', 'editor.id_user = pendaftaran_skkd.updated_by', 'left');

        $data = $builder->find($id);

        if ($data) {
            return $this->response->setJSON($data);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Data tidak ditemukan']);
        }
    }

    /**
     * =========================
     * UPDATE
     * =========================
     */
    public function update($id)
    {
        // Yang diupdate adalah data FISIK pendaftaran, bukan biodata pasien
        $data = [
            'tinggi_badan'    => $this->request->getPost('tinggi_badan'),
            'berat_badan'     => $this->request->getPost('berat_badan'),
            'golongan_darah'  => $this->request->getPost('golongan_darah'),
            'tekanan_darah'   => $this->request->getPost('tekanan_darah'),
            'keperluan_surat' => $this->request->getPost('keperluan_surat'),

            // Jangan lupa catat siapa yang ngedit
            'updated_by'      => session()->get('id_user')
        ];

        // Bisa tambahkan validasi jika perlu, misal id_dokter berubah
        if ($this->request->getPost('id_dokter')) {
            $data['id_dokter'] = $this->request->getPost('id_dokter');
        }

        $this->pendaftaran_skkd->update($id, $data);

        return $this->response->setJSON(['status' => true, 'message' => 'Data pendaftaran berhasil diubah']);
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function delete($id)
    {
        $this->pendaftaran_skkd->delete($id);

        return $this->response->setJSON(['status' => true, 'message' => 'Data pendaftaran dihapus']);
    }
        private function bulanRomawi($bulan)
    {
        $map = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        return $map[(int)$bulan];
    }
    public function updateStatus($id)
    {
        $pendaftaran = $this->pendaftaran_skkd->find($id);

        if (!$pendaftaran) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        $currentStatus = $pendaftaran['status'];

        // Hanya boleh diverifikasi sekali
        if ($currentStatus !== 'Menunggu') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status sudah diverifikasi'
            ]);
        }

        /** ============================
         *  1. GENERATE NOMOR SURAT
         *  ============================
         */
        $last = $this->skkd->getLastUrutan();

        $urutan = 1;
        if ($last) {
            preg_match('/440\s*\/\s*(\d+)/', $last['nomor_surat'], $match);
            $urutan = isset($match[1]) ? ((int)$match[1] + 1) : 1;
        }

        $bulanRomawi = $this->bulanRomawi(date('n'));
        $tahun = date('Y');

        $nomorSurat = "440 / {$urutan} / {$bulanRomawi} / {$tahun}";

        /** ============================
         *  2. INSERT KE TABEL SKKD
         *  ============================
         */
        $this->skkd->insert([
            'nomor_surat'    => $nomorSurat,
            'id_pendaftaran' => $id,
            'created_by'    => session()->get('id_user')
        ]);

        /** ============================
         *  3. UPDATE STATUS PENDAFTARAN
         *  ============================
         */
        $this->pendaftaran_skkd->update($id, [
            'status'     => 'Terverifikasi',
            'updated_by' => session()->get('id_user')
        ]);

        return $this->response->setJSON([
            'success' => true,
            'status'  => 'Terverifikasi',
            'nomor_surat' => $nomorSurat
        ]);
    }
}
