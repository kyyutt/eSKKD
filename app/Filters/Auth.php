<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    /**
     * Route yang boleh diakses tanpa login
     */
    protected array $exceptRoutes = [
        'login',
        'login/*',
        'logout',
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = service('uri')->getPath();

        // 🔹 Lewati route login & logout
        foreach ($this->exceptRoutes as $except) {
            if (fnmatch($except, $uri)) {
                return;
            }
        }

        // 🔹 Cek session login
        if (! session()->get('isLoggedIn')) {
            return redirect()
                ->to('/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // Tidak perlu
    }
}
