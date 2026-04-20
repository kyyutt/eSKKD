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

        // Validasi Input - Tambahin dikit biar lebih mantap
        if (!$this->validate([
            'id_pasien'       => 'required',
            'id_dokter'       => 'required',
            'tanggal_periksa' => 'required|valid_date',
            'keperluan_surat' => 'required|min_length[5]', // Biar nggak asal isi
            'goldar'          => 'required',
            'tinggi_badan'    => 'required|numeric',
            'berat_badan'     => 'required|numeric',
            'tekanan_darah'   => 'required',
        ])) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Mapping data + Cukur spasi (trim)
        $data = [
            'id_pasien'       => $this->request->getPost('id_pasien'),
            'id_dokter'       => $this->request->getPost('id_dokter'),
            'tanggal_periksa' => $this->request->getPost('tanggal_periksa'),
            'golongan_darah'  => $this->request->getPost('goldar'),
            'tinggi_badan'    => trim($this->request->getPost('tinggi_badan')),
            'berat_badan'     => trim($this->request->getPost('berat_badan')),
            'tekanan_darah'   => trim($this->request->getPost('tekanan_darah')),
            'keperluan_surat' => trim($this->request->getPost('keperluan_surat')),
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
                'message' => 'Gagal menyimpan data ke database.'
                // Jangan tampilin $e->getMessage() ke user ya, rawan security!
            ]);
        }
    }
}
