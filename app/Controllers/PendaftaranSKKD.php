<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DokterModel;
use App\Models\PendaftaranSKKDModel;
use App\Models\PasienModel;

class PendaftaranSKKD extends BaseController
{
    protected $dokterModel;
    protected $pendaftaranModel;
    protected $pasienModel;

    public function __construct()
    {
        $this->dokterModel = new DokterModel();
        $this->pendaftaranModel = new PendaftaranSKKDModel();
        $this->pasienModel = new PasienModel();
    }

    // 1. TAMPILKAN FORM
    public function index()
    {
        // Ambil data dokter untuk dropdown
        $data = [
            'title'   => 'Input Pendaftaran SKKD',
            'subtitle' => 'Isi data pendaftaran SKKD di sini',
            'dokters' => $this->dokterModel->findAll()
        ];

        return view('pendaftaran/index', $data);
    }

    // 2. CARI PASIEN (AJAX)
    public function searchPasien()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        $keyword = $this->request->getGet('keyword');

        // Cari berdasarkan Nama ATAU NIK
        $results = $this->pasienModel
            ->groupStart()
            ->like('nama_lengkap', $keyword)
            ->orLike('nik', $keyword)
            ->groupEnd()
            ->findAll(10);

        return $this->response->setJSON($results);
    }

    // 3. SIMPAN DATA (AJAX)
    public function store()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        // Validasi Input
        if (!$this->validate([
            'id_pasien'       => 'required',
            'id_dokter'       => 'required',
            'tanggal_periksa' => 'required|valid_date',
            'keperluan_surat' => 'required',
            'goldar'          => 'required',
        ])) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Mapping data
        $data = [
            'id_pasien'       => $this->request->getPost('id_pasien'),
            'id_dokter'       => $this->request->getPost('id_dokter'),
            'tanggal_periksa' => $this->request->getPost('tanggal_periksa'),
            'golongan_darah'  => $this->request->getPost('goldar'),
            'tinggi_badan'    => $this->request->getPost('tinggi_badan'),
            'berat_badan'     => $this->request->getPost('berat_badan'),
            'tekanan_darah'   => $this->request->getPost('tekanan_darah'),
            'keperluan_surat' => $this->request->getPost('keperluan_surat'),
            'created_by'      => session()->get('id_user'),
            'status'          => 'Menunggu',
        ];

        try {
            $this->pendaftaranModel->insert($data);
            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Data pendaftaran berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ]);
        }
    }
}
