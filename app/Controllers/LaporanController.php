<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SKKDModel;
use App\Models\PendaftaranSKKDModel;
use App\Models\PasienModel;
use App\Models\DokterModel;

class LaporanController extends BaseController
{
    protected $skkdModel;
    protected $pendaftaranModel;
    protected $pasienModel;
    protected $dokterModel;

    public function __construct()
    {
        $this->skkdModel = new SKKDModel();
        $this->pendaftaranModel = new PendaftaranSKKDModel();
        $this->pasienModel = new PasienModel();
        $this->dokterModel = new DokterModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Rekapitulasi SKKD',
            'subtitle' => 'Lihat dan cetak laporan rekapitulasi Surat Keterangan Kesehatan Dokter'
        ];
        return view('laporan/index', $data);
    }

    public function getData()
    {
        $request = service('request');
        
        $startDate = $request->getGet('start_date');
        $endDate   = $request->getGet('end_date');
        $page      = $request->getGet('page') ?? 1;
        $perPage   = 10;

        // -----------------------------------------------------------
        // 1. AMBIL DATA UNTUK STATISTIK (SUMMARY CARDS)
        // -----------------------------------------------------------
        // Kita perlu mengambil SEMUA data tanpa pagination untuk dihitung total L/P-nya
        $this->_applyFilter($startDate, $endDate); 
        $allData = $this->skkdModel->findAll(); // findAll() akan mereset query setelah dijalankan
        
        $stats = $this->_calculateStats($allData, $startDate, $endDate);

        // -----------------------------------------------------------
        // 2. AMBIL DATA UNTUK TABEL (PAGINATION)
        // --------------------------------------------------------
        $this->_applyFilter($startDate, $endDate);
        
        $this->skkdModel->orderBy('skkd.created_at', 'DESC');
        $results = $this->skkdModel->paginate($perPage, 'default', $page); // Sekarang paginate bisa jalan
        $pager   = $this->skkdModel->pager;

        return $this->response->setJSON([
            'status'  => 'success',
            'summary' => $stats,
            'data'    => $results,
            'pager'   => [
                'current_page' => (int)$page,
                'total_pages'  => $pager->getPageCount(),
                'total_items'  => $pager->getTotal()
            ]
        ]);
    }

    public function cetak()
    {
        $request = service('request');

        $startDate = $request->getGet('start_date');
        $endDate   = $request->getGet('end_date');

        $this->_applyFilter($startDate, $endDate);
        $this->skkdModel->orderBy('skkd.created_at', 'ASC');
        
        $results = $this->skkdModel->findAll();
        
        $stats = $this->_calculateStats($results, $startDate, $endDate);

        $data = [
            'title'     => 'Cetak Laporan SKKD',
            'data_skkd' => $results,
            'statistik' => $stats,
            'periode'   => [
                'start' => $startDate,
                'end'   => $endDate
            ]
        ];

        return view('laporan/cetak', $data);
    }

    // =========================================================================
    // PRIVATE HELPER FUNCTIONS
    // =========================================================================

    private function _applyFilter($startDate, $endDate)
    {
        // PENTING: Jangan gunakan ->builder(), pakai modelnya langsung
        // agar method paginate() tetap tersedia.
        
        $this->skkdModel->select('
            skkd.id_skkd, 
            skkd.nomor_surat, 
            skkd.created_at as tanggal_terbit,
            pasien.nama_lengkap as nama_pasien,
            pasien.nik,
            pasien.jenis_kelamin,
            dokter.nama_dokter,
            pendaftaran_skkd.status
        ');

        $this->skkdModel->join('pendaftaran_skkd', 'pendaftaran_skkd.id_pendaftaran = skkd.id_pendaftaran');
        $this->skkdModel->join('pasien', 'pasien.id_pasien = pendaftaran_skkd.id_pasien');
        $this->skkdModel->join('dokter', 'dokter.id_dokter = pendaftaran_skkd.id_dokter');

        if ($startDate && $endDate) {
            $this->skkdModel->where("DATE(skkd.created_at) >=", $startDate);
            $this->skkdModel->where("DATE(skkd.created_at) <=", $endDate);
        }
    }

    private function _calculateStats($dataArray, $startDate, $endDate)
    {
        $totalData      = count($dataArray);
        $totalLaki      = 0;
        $totalPerempuan = 0;

        foreach ($dataArray as $row) {
            // Cek variasi penulisan di database
            $jk = $row['jenis_kelamin'];
            if ($jk == 'L' || $jk == 'Laki-laki') {
                $totalLaki++;
            } else {
                $totalPerempuan++;
            }
        }

        $avgPerDay = $totalData; 
        if ($startDate && $endDate && $totalData > 0) {
            $startObj = new \DateTime($startDate);
            $endObj   = new \DateTime($endDate);
            $diff     = $startObj->diff($endObj)->days + 1; 
            
            if ($diff > 0) {
                $avgPerDay = round($totalData / $diff, 1);
            }
        }

        return [
            'total_skkd'      => $totalData,
            'total_laki'      => $totalLaki,
            'total_perempuan' => $totalPerempuan,
            'rata_rata'       => $avgPerDay
        ];
    }
}