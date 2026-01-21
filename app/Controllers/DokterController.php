<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DokterModel;
use App\Models\UserModel;

class DokterController extends BaseController
{
    protected $user;
    protected $dokter;
    public function __construct()
    {
        $this->dokter = new DokterModel();
        $this->user   = new UserModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Manajemen Data Dokter',
            'subtitle' => 'Kelola data dokter SKKD di sini'
        ];
        return view('dokter/index', $data);
    }
    public function ajaxList()
    {
        $page   = (int) ($this->request->getGet('page') ?? 1);
        $limit  = (int) ($this->request->getGet('limit') ?? 10);
        $search = $this->request->getGet('search');

        $offset = ($page - 1) * $limit;

        $builder = $this->dokter;

        // SEARCH (NIK / NAMA)
        if ($search) {
            // Daftar kolom yang mau dicari
            $kolom = ['nama_dokter', 'nomor_identitas'];

            $builder->groupStart();
            foreach ($kolom as $k) {
                $builder->orLike($k, $search);
            }
            $builder->groupEnd();
        }

        $total = $builder->countAllResults(false);

        $data = $builder
            ->orderBy('id_dokter', 'DESC')
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
     * STORE
     * =========================
     */
    public function store()
    {
        $nomor_identitas = $this->request->getPost('nomor_identitas');

        // Check if nomor_identitas already exists
        $existing = $this->dokter->where('nomor_identitas', $nomor_identitas)->first();
        if ($existing) {
            return $this->response->setJSON(['status' => false, 'message' => 'Nomor identitas sudah terdaftar'], 400);
        }

        $this->dokter->insert([
            'nama_dokter'   => strtoupper($this->request->getPost('nama_dokter')),
            'nomor_identitas' => $nomor_identitas,
            'created_by'    => session()->get('id_user'),
        ]);

        return $this->response->setJSON(['status' => true]);
    }

    /**
     * =========================
     * UPDATE
     * =========================
     */
    public function update($id)
    {
        $nomor_identitas = $this->request->getPost('nomor_identitas');

        // Check if nomor_identitas already exists (excluding current record)
        $existing = $this->dokter->where('nomor_identitas', $nomor_identitas)->where('id_dokter !=', $id)->first();
        if ($existing) {
            return $this->response->setJSON(['status' => false, 'message' => 'Nomor identitas sudah terdaftar'], 400);
        }

        $this->dokter->update($id, [
            'nama_dokter'   => strtoupper($this->request->getPost('nama_dokter')),
            'nomor_identitas' => $nomor_identitas,
            'updated_by'    => session()->get('id_user'),
        ]);
        return $this->response->setJSON(['status' => true]);
    }

    public function delete($id)
    {
        $this->dokter->delete($id);
        return $this->response->setJSON(['status' => true]);
    }
}
