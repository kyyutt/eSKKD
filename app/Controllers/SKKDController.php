<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SKKDModel;
use App\Models\PendaftaranSKKDModel;

class SKKDController extends BaseController
{
    protected $skkd;
    protected $pendaftaran;

    public function __construct()
    {
        $this->skkd        = new SKKDModel();
        $this->pendaftaran = new PendaftaranSKKDModel();
    }
    public function index()
    {
        $data = [
            'title'    => 'Manajemen Data SKKD',
            'subtitle' => 'Kelola data Surat Keterangan Kesehatan Dokter di sini'
        ];
        return view('skkd/index', $data);
    }

    public function ajaxList()
    {
        $page   = (int) ($this->request->getGet('page') ?? 1);
        $limit  = (int) ($this->request->getGet('limit') ?? 10);
        $search = $this->request->getGet('search');
        $offset = ($page - 1) * $limit;

        $builder = $this->skkd->select('skkd.*, pasien.nama_lengkap as nama_pasien, pasien.nik, dokter.nama_dokter, pendaftaran_skkd.status')
            ->join('pendaftaran_skkd', 'pendaftaran_skkd.id_pendaftaran = skkd.id_pendaftaran')
            ->join('pasien', 'pasien.id_pasien = pendaftaran_skkd.id_pasien')
            ->join('dokter', 'dokter.id_dokter = pendaftaran_skkd.id_dokter');

        if ($search) {
            $builder->groupStart()
                ->like('skkd.nomor_surat', $search)
                ->orLike('pasien.nama_lengkap', $search)
                ->orLike('pasien.nik', $search)
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $data  = $builder->orderBy('skkd.id_skkd', 'DESC')->findAll($limit, $offset);

        return $this->response->setJSON([
            'data'       => $data,
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
     * Show Detail - Ambil data fisik dari join Pendaftaran
     */
    public function show($id)
    {
        $data = $this->skkd->select('
                skkd.*, 
                pasien.nama_lengkap, pasien.nik, 
                dokter.nama_dokter,
                pendaftaran_skkd.tinggi_badan, 
                pendaftaran_skkd.berat_badan, 
                pendaftaran_skkd.tekanan_darah,
                pendaftaran_skkd.golongan_darah,
                pendaftaran_skkd.keperluan_surat
            ')
            ->join('pendaftaran_skkd', 'pendaftaran_skkd.id_pendaftaran = skkd.id_pendaftaran')
            ->join('pasien', 'pasien.id_pasien = pendaftaran_skkd.id_pasien')
            ->join('dokter', 'dokter.id_dokter = pendaftaran_skkd.id_dokter')
            ->find($id);

        return $this->response->setJSON($data);
    }
    /**
     * Hapus SKKD
     * Saat SKKD dihapus, status pendaftaran dikembalikan ke 'Verifikasi'
     */
    public function delete($id)
    {
        // 1. Cari data SKKD untuk mendapatkan id_pendaftaran
        $dataSKKD = $this->skkd->find($id);

        if ($dataSKKD) {
            // 2. Hapus data pendaftaran terkait
            $this->pendaftaran->delete($dataSKKD['id_pendaftaran']);

            // 3. Hapus data SKKD
            $this->skkd->delete($id);

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Data SKKD dan pendaftaran berhasil dihapus'
            ]);
        }

        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }
    public function cetak($id_skkd)
    {
        $skkd = $this->skkd->find($id_skkd);

        if (!$skkd) {
            return $this->response->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        // Ambil data pendaftaran terkait
        $pendaftaran = $this->pendaftaran->find($skkd['id_pendaftaran']);

        // LOGIKA: Jika status sudah 'Selesai', jangan update lagi
        if ($pendaftaran['status'] === 'Selesai') {
            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Sudah berstatus Selesai, siap cetak ulang.'
            ]);
        }

        // Jika belum 'Selesai' (misal masih 'Verifikasi'), baru lakukan update
        $this->pendaftaran->update($skkd['id_pendaftaran'], [
            'status'     => 'Selesai',
            'updated_by' => session()->get('id_user')
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Status berhasil diperbarui ke Selesai.'
        ]);
    }
    public function print_pdf($id_skkd)
    {
        // Ambil data gabungan untuk mengisi variabel di view cetak_skkd.php
        $data = $this->skkd->select('
                skkd.nomor_surat, 
                skkd.created_at as tgl_terbit,
                pasien.nama_lengkap, 
                pasien.nik, 
                pasien.tempat_lahir, 
                pasien.tanggal_lahir, 
                pasien.pekerjaan, 
                pasien.alamat,
                pendaftaran_skkd.tinggi_badan, 
                pendaftaran_skkd.berat_badan, 
                pendaftaran_skkd.tekanan_darah, 
                pendaftaran_skkd.golongan_darah, 
                pendaftaran_skkd.keperluan_surat,
                dokter.nama_dokter, 
                dokter.nomor_identitas
            ')
            ->join('pendaftaran_skkd', 'pendaftaran_skkd.id_pendaftaran = skkd.id_pendaftaran')
            ->join('pasien', 'pasien.id_pasien = pendaftaran_skkd.id_pasien')
            ->join('dokter', 'dokter.id_dokter = pendaftaran_skkd.id_dokter')
            ->where('skkd.id_skkd', $id_skkd)
            ->first();

        if (!$data) {
            return "Maaf, data surat tidak ditemukan atau sudah dihapus.";
        }

        return view('skkd/cetak', ['d' => $data]);
    }
}
