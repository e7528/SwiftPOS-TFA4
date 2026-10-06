<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'full_name',
        'role',
        'password',
        'attendance_status',
        'is_verified',
        'avatar',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    protected $validationRules = [
        'username'          => 'required|max_length[50]|is_unique[users.username,id,{id}]',
        'full_name'         => 'required|max_length[100]',
        'role'              => 'required|in_list[Admin,Store Manager,Cashier,Inventory]',
        'password'          => 'required|max_length[255]',
        'attendance_status' => 'required|in_list[Clocked In,Clocked Out,PTO,AWOL]',
        'is_verified'       => 'permit_empty|in_list[0,1]',
        'avatar'            => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
