<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'full_name',
        'email',
        'phone',
        'password_hash',
        'status',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    protected $validationRules = [
        'full_name'     => 'required|max_length[100]',
        'email'         => 'required|valid_email|max_length[100]|is_unique[customers.email,id,{id}]',
        'phone'         => 'permit_empty|max_length[25]',
        'password_hash' => 'required|max_length[255]',
        'status'        => 'required|in_list[Active,Inactive]',
    ];

    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
