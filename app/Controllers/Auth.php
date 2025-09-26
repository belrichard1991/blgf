<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

   public function loginPost()
    {
        $session = session();
        $model = new \App\Models\UserModel();

        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));
        $hashedPassword = hash('sha256', $password);

        // Fetch user from DB
        $user = $model->where('username', $username)->first();

        echo "<pre>";
        echo "Input Username: " . $username . "\n";
        echo "Input Password: " . $password . "\n";
        echo "Hashed Input: " . $hashedPassword . "\n";
        echo "User Found: ";
        print_r($user);

        if ($user && $user['password'] === $hashedPassword) {
            echo "\npassword_match: ✅ MATCH";

            // Set session and redirect
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'logged_in' => true
            ]);

            return redirect()->to('employee'); // or your correct route
        } else {
            echo "\npassword_match: ❌ NO MATCH";
            echo "</pre>";
            return redirect()->back()->with('error', 'Invalid login credentials.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
