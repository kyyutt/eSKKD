<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class PasienController extends BaseController
{
    protected $pasien;
    protected $user;

    public function __construct()
    {
        $this->pasien = new PasienModel();
        $this->user   = new UserModel();
    }

    /**
     * =========================
     * PAGE
     * =========================
     */
    public function index()
    {
        $data = [
            'title' => 'Manajemen Data Pasien',
            'subtitle' => 'Kelola data pasien SKKD di sini'
        ];
        return view('pasien/index', $data);
    }

    /**
     * =========================
     * AJAX LIST (TABLE + PAGINATION)
     * =========================
     */
    public function ajaxList()
    {
        $page   = (int) ($this->request->getGet('page') ?? 1);
        $limit  = (int) ($this->request->getGet('limit') ?? 10);
        $search = $this->request->getGet('search');

        $offset = ($page - 1) * $limit;

        $builder = $this->pasien;

        // SEARCH (NIK / NAMA)
        if ($search) {
            // Daftar kolom yang mau dicari
            $kolom = ['nik', 'nama_lengkap', 'alamat', 'pekerjaan', 'tempat_lahir'];

            $builder->groupStart();
            foreach ($kolom as $k) {
                $builder->orLike($k, $search);
            }
            $builder->groupEnd();
        }

        $total = $builder->countAllResults(false);

        $data = $builder
            ->orderBy('id_pasien', 'DESC')
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
        $this->pasien->insert([
            'nik'            => $this->request->getPost('nik'),
            'nama_lengkap'   => strtoupper($this->request->getPost('nama_lengkap')),
            'tempat_lahir'   => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir'  => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin'  => $this->request->getPost('jenis_kelamin'),
            'pekerjaan'      => $this->request->getPost('pekerjaan'),
            'alamat'         => $this->request->getPost('alamat'),
            'created_by'     => session()->get('id_user'),
        ]);

        return $this->response->setJSON(['status' => true]);
    }

    /**
     * =========================
     * DETAIL
     * =========================
     */
    public function show($id)
    {
        $pasien = $this->pasien->find($id);
        if ($pasien['created_by']) {
            $createdByUser = $this->user->find($pasien['created_by']);
            $pasien['created_by_name'] = $createdByUser['nama_lengkap'] ?? null;
        }
        if ($pasien['updated_by']) {
            $updatedByUser = $this->user->find($pasien['updated_by']);
            $pasien['updated_by_name'] = $updatedByUser['nama_lengkap'] ?? null;
        }

        return $this->response->setJSON($pasien);
    }

    /**
     * =========================
     * UPDATE
     * =========================
     */
    public function update($id)
    {
        $this->pasien->update($id, [
            'nama_lengkap'  => strtoupper($this->request->getPost('nama_lengkap')),
            'tempat_lahir'  => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'pekerjaan'     => $this->request->getPost('pekerjaan'),
            'alamat'        => $this->request->getPost('alamat'),
            'updated_by'    => session()->get('id_user'),
        ]);

        return $this->response->setJSON(['status' => true]);
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function delete($id)
    {
        $this->pasien->delete($id);

        return $this->response->setJSON(['status' => true]);
    }
}
