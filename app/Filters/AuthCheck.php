<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthCheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = trim($request->getUri()->getPath(), '/'); // "login", "dashboard", ""

        $isLoggedIn = session()->get('logged_in');

        // ✅ If NOT logged in and not going to login page → redirect to login
        if (!$isLoggedIn && !in_array($uri, ['login', 'auth/loginPost'])) {
            return redirect()->to('/login');
        }

        // ✅ If logged in and tries to access login page → redirect to dashboard (or records)
        if ($isLoggedIn && in_array($uri, ['login', 'auth/loginPost'])) {
            return redirect()->to('/dashboard'); // change to 'records' if needed
        }

        // ✅ If root URL `/`:
        if ($uri === '') {
            if ($isLoggedIn) {
                return redirect()->to('/records'); // show Records when logged in
            } else {
                return redirect()->to('/login'); // login when logged out
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No after-filter actions
    }
}
