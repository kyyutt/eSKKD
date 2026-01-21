<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Jika sudah login, lempar ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('login');
    }

    public function processLogin()
    {
        $userModel = new UserModel();

        // --- FITUR AUTO SEED (Opsional: Buat User Admin jika database kosong) ---
        if ($userModel->countAllResults() === 0) {
            $userModel->insert([
                'nama_lengkap' => 'Administrator',
                'username'     => 'admin',
                'password'     => password_hash('admin123', PASSWORD_DEFAULT),
                'role'         => 'Admin',
            ]);
        }

        // 1. Ambil Input
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // 2. Cari User
        $user = $userModel->where('username', $username)->first();

        // 3. Cek Password
        if ($user && password_verify($password, $user['password'])) {

            $userModel->update($user['id_user'], [
                'last_login' => date('Y-m-d H:i:s')
            ]);

            session()->set([
                'isLoggedIn'   => true,
                'id_user'      => $user['id_user'],
                'nama_lengkap' => $user['nama_lengkap'],
                'username'     => $user['username'],
                'role'         => $user['role'],
            ]);

            return redirect()->to('/');
        }

        // Jika Gagal
        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
