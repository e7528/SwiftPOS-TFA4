<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('url');
        $id = session()->get('auth_user_id');

        // An old session cannot grant access after its user is removed.
        if (! is_numeric($id) || (int) $id < 1 || (new UserModel())->find((int) $id) === null) {
            session()->remove(['auth_user_id', 'auth_username']);

            return redirect()->to(site_url('login'))->with('error', 'Please log in to continue.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
