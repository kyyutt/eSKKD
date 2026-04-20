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
        $db = \Config\Database::connect();
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

        $lastBackup = $db->table('sys_settings')->where('key_name', 'last_backup')->get()->getRow()->key_value;

        $data = [
            'title'          => 'Dashboard Utama',
            'subtitle'       => 'Selamat datang kembali, ' . session()->get('nama_lengkap'),
            'stats'          => $dataStats,
            'recentSKKD'     => $recentSKKD,
            'recentAntrean'  => $recentAntrean,
            'lastBackup'     => $lastBackup
        ];

        return view('dashboard', $data);
    }
    public function backup_database()
    {
        $db = \Config\Database::connect();

        // --- TAMBAHKAN INI: Update tanggal terakhir backup ---
        $now = date('d F Y'); // Format: 12 March 2026
        $db->table('sys_settings')
            ->where('key_name', 'last_backup')
            ->update(['key_value' => $now]);
        // -----------------------------------------------------

        $fileName = "E-SKKD_Backup_" . date('Y-m-d_H-i-s') . ".sql";
        $mysqldumpPath = 'C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqldump.exe';

        header('Content-Type: application/octet-stream');
        header("Content-disposition: attachment; filename=\"$fileName\"");

        $command = "\"$mysqldumpPath\" --user={$db->username} --password={$db->password} {$db->database}";
        passthru($command);
        exit;
    }
    public function restore_database()
    {
        // 1. Ambil file yang dikirim dari JS
        $file = $this->request->getFile('sql_file');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            // 2. Konfigurasi Database
            $db = \Config\Database::connect();
            $username = $db->username;
            $password = $db->password;
            $database = $db->database;

            // 3. Path tools mysql.exe di Laragon (Pastikan path ini benar di laptop server)
            $mysqlPath = 'C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysql.exe';

            // 4. Dapatkan lokasi sementara file yang baru diupload
            $tempPath = $file->getTempName();

            // 5. Perintah Sakti: mysql -u root -p database < file.sql
            // Kita gunakan tanda kutip ganda pada path untuk menghindari error jika ada spasi
            $command = "\"$mysqlPath\" --user=$username --password=$password $database < \"$tempPath\"";

            // 6. Eksekusi perintah di sistem Windows
            exec($command, $output, $returnVar);

            // 7. Cek apakah berhasil (returnVar 0 berarti sukses)
            if ($returnVar === 0) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => 'Database Berhasil Dipulihkan! Sistem akan memuat ulang halaman.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Gagal mengeksekusi file SQL. Pastikan format benar.'
                ], 500);
            }
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'File tidak valid atau tidak ditemukan.'
        ], 400);
    }
}
