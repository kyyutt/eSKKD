<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    // Fuctions for Authentication
    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('login');
    }

    // Process Login Form Submission
    public function processLogin()
    {

        // Create default admin user if none exists
        if ($this->userModel->countAllResults() === 0) {
            $this->userModel->insert([
                'nama_lengkap' => 'Administrator',
                'username'     => 'admin',
                'password'     => password_hash('admin123', PASSWORD_DEFAULT),
                'role'         => 'Admin',
            ]);
        }

        // First, get input data
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Second, find user by username
        $user = $this->userModel->where('username', $username)->first();

        // Third, verify password
        if ($user && password_verify($password, $user['password'])) {

            $this->userModel->update($user['id_user'], [
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

        // If login fails, redirect back with error
        return redirect()->back()->with('error', 'Username atau password salah');
    }

    // Logout Function
    public function logout()
    {
        // Destroy session and redirect to login
        session()->destroy();
        return redirect()->to('/login');
    }
}
