<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\DokterModel;
use App\Models\PendaftaranSKKDModel;
use App\Models\SKKDModel;

class DashboardController extends BaseController
{
    protected $pasienModel;
    protected $dokterModel;
    protected $pendaftaranModel;
    protected $skkdModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
        $this->dokterModel = new DokterModel();
        $this->pendaftaranModel = new PendaftaranSKKDModel();
        $this->skkdModel = new SKKDModel();
    }

    public function index()
    {
        $today = date('Y-m-d');

        // --- Data Statistik ---
        $dataStats = [
            // 1. Total Pasien (Khusus Hari Ini)
            'totalPasienHariIni' => $this->pendaftaranModel
                                    ->where('DATE(created_at)', $today)
                                    ->countAllResults(),

            // 2. Total SKKD (Dokumen) Seumur Hidup
            'totalSKKDTerbit'    => $this->skkdModel->countAllResults(),

            // 3. Total Dokter
            'totalDokter'        => $this->dokterModel->countAllResults(),

            // 4. Antrean (Status: Menunggu)
            'antreanLoket'       => $this->pendaftaranModel
                                    ->where('status', 'Menunggu')
                                    ->where('DATE(created_at)', $today)
                                    ->countAllResults(),

            // 5. Sedang Proses (Status: Verifikasi)
            'sedangVerifikasi'   => $this->pendaftaranModel
                                    ->where('status', 'Terverifikasi')
                                    ->where('DATE(created_at)', $today)
                                    ->countAllResults(),
            
            // 6. Selesai (Status: Selesai)
            'selesaiHariIni'     => $this->pendaftaranModel
                                    ->where('status', 'Selesai')
                                    ->where('DATE(created_at)', $today)
                                    ->countAllResults(),
        ];

        // --- Data Tabel (Recent Logs) ---
        
        // Tabel Riwayat SKKD (Biasanya mengambil yang sudah ada di tabel SKKD atau status Selesai)
        $recentSKKD = $this->skkdModel->select('skkd.*, pendaftaran_skkd.status, pasien.nama_lengkap as nama_pasien, pasien.nik, dokter.nama_dokter')
            ->join('pendaftaran_skkd', 'pendaftaran_skkd.id_pendaftaran = skkd.id_pendaftaran')
            ->join('pasien', 'pasien.id_pasien = pendaftaran_skkd.id_pasien')
            ->join('dokter', 'dokter.id_dokter = pendaftaran_skkd.id_dokter')
            ->orderBy('skkd.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        // Tabel Antrean Terbaru (Semua status)
        $recentAntrean = $this->pendaftaranModel->select('pendaftaran_skkd.*, pasien.nama_lengkap, pasien.nik')
            ->join('pasien', 'pasien.id_pasien = pendaftaran_skkd.id_pasien')
            ->where('DATE(pendaftaran_skkd.created_at)', $today) // Hanya tampilkan hari ini
            ->orderBy('pendaftaran_skkd.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        $data = [
            'title'          => 'Dashboard Utama',
            'subtitle'       => 'Selamat datang kembali, ' . session()->get('nama_lengkap'),
            'stats'          => $dataStats,
            'recentSKKD'     => $recentSKKD,
            'recentAntrean'  => $recentAntrean,
        ];

        return view('dashboard', $data);
    }
}