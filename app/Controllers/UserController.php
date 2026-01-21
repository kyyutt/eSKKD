<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $user;
    public function __construct()
    {
        $this->user = new UserModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Manajemen Data User',
            'subtitle' => 'Kelola data user di sini'
        ];
        return view('user/index', $data);
    }
    public function ajaxList()
    {
        $page   = (int) ($this->request->getGet('page') ?? 1);
        $limit  = (int) ($this->request->getGet('limit') ?? 10);
        $search = $this->request->getGet('search');
        $currantUserId = session()->get('id_user');

        $offset = ($page - 1) * $limit;

        $builder = $this->user;

        $builder->where('id_user !=', $currantUserId); // Exclude current user

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
            ->orderBy('id_user', 'DESC')
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
    // Tambahkan fungsi ini untuk mengambil data 1 user
    public function get($id)
    {
        $data = $this->user->find($id);

        if ($data) {
            return $this->response->setJSON($data);
        } else {
            return $this->response->setJSON(['message' => 'User tidak ditemukan'], 404);
        }
    }
    public function store()
    {
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'         => $this->request->getPost('role'),
        ];

        $this->user->insert($data);

        return $this->response->setJSON(['status' => true, 'message' => 'Data user berhasil ditambahkan']);
    }

    public function update($id)
    {
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'role'         => $this->request->getPost('role'),
        ];

        // Cek apakah password diisi
        $password = $this->request->getPost('password');
        if ($password) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->user->update($id, $data);

        return $this->response->setJSON(['status' => true, 'message' => 'Data user diperbarui']);
    }
    public function delete($id)
    {
        $this->user->delete($id);

        return $this->response->setJSON(['status' => true, 'message' => 'Data user dihapus']);
    }

    public function getMyProfile()
    {
        $id = session()->get('id_user');
        $user = $this->user->find($id);
        if ($user) {
            unset($user['password']); // Keamanan: jangan kirim hash password ke JS
            return $this->response->setJSON($user);
        }
        return $this->response->setJSON(['status' => false], 404);
    }

    // 2. Fungsi update profil
    public function updateMyProfile()
    {
        $id = session()->get('id_user');
        $user = $this->user->find($id);

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');

        $dataUpdate = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
        ];

        if (!empty($passwordBaru)) {
            if (empty($passwordLama)) {
                return $this->response->setJSON(['status' => false, 'message' => 'Password lama wajib diisi!']);
            }
            if (!password_verify($passwordLama, $user['password'])) {
                return $this->response->setJSON(['status' => false, 'message' => 'Password lama salah!']);
            }
            $dataUpdate['password'] = password_hash($passwordBaru, PASSWORD_BCRYPT);
        }

        if ($this->user->update($id, $dataUpdate)) {
            session()->set([
                'nama_lengkap' => $dataUpdate['nama_lengkap'],
                'username'     => $dataUpdate['username']
            ]);
            return $this->response->setJSON(['status' => true, 'message' => 'Profil diperbarui!']);
        }
        return $this->response->setJSON(['status' => false, 'message' => 'Gagal update']);
    }
}
