<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    public function login(): string|RedirectResponse
    {
        $id = session()->get('auth_user_id');
        if (is_numeric($id) && (new UserModel())->find((int) $id) !== null) {
            return redirect()->to(site_url('customers'));
        }

        $data = ['title' => 'Staff Login | SwiftPOS'];

        return view('templates/header', $data)
             . view('auth/login', $data)
             . view('templates/footer');
    }

    public function authenticate(): RedirectResponse
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $username = is_string($username) ? trim($username) : '';
        $password = is_string($password) ? $password : '';

        $user = $username === '' ? null : (new UserModel())->where('username', $username)->first();

        if ($user === null || ! is_string($user['password'] ?? null)
            || ! password_verify($password, $user['password'])) {
            return redirect()->to(site_url('login'))->with('error', 'Invalid username or password.');
        }

        // Replace the anonymous session ID before marking this session as authenticated.
        session()->regenerate(true);
        session()->set([
            'auth_user_id'  => (int) $user['id'],
            'auth_username' => (string) $user['username'],
        ]);

        return redirect()->to(site_url('customers'));
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }
}
