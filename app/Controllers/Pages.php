<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\UserModel;

class Pages extends BaseController
{
    public function index(): string
    {
        $customerModel = new CustomerModel();
        $userModel     = new UserModel();
        $customers     = $customerModel->select(['id'])->findAll();
        $users         = $userModel->select(['id', 'role'])->findAll();

        $data = [
            'title'         => 'Dashboard | SwiftPOS',
            'customerCount' => count($customers),
            'userCount'     => count($users),
            'roleCount'     => count(array_unique(array_column($users, 'role'))),
        ];

        return view('templates/header', $data)
             . view('pages/landing', $data)
             . view('templates/footer');
    }

    public function about(): string
    {
        $data = [
            'title' => 'About | SwiftPOS',
        ];

        return view('templates/header', $data)
             . view('pages/about', $data)
             . view('templates/footer');
    }
}
