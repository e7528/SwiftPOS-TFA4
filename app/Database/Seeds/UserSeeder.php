<?php

namespace App\Database\Seeds;

use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $users = [
            [
                'username'          => 'admin_reign',
                'full_name'         => 'Adrien Russel Tan',
                'role'              => 'Admin',
                'password'          => '',
                'attendance_status' => 'Clocked In',
                'is_verified'       => true,
                'created_at'        => $now,
            ],
            [
                'username'          => 'mgr_echo',
                'full_name'         => 'Jericho Macarang',
                'role'              => 'Store Manager',
                'password'          => '',
                'attendance_status' => 'Clocked Out',
                'is_verified'       => true,
                'created_at'        => $now,
            ],
            [
                'username'          => 'cashier_aaa',
                'full_name'         => 'aaa',
                'role'              => 'Cashier',
                'password'          => '',
                'attendance_status' => 'PTO',
                'is_verified'       => true,
                'created_at'        => $now,
            ],
            [
                'username'          => 'cashier_bbb',
                'full_name'         => 'bbb',
                'role'              => 'Cashier',
                'password'          => '',
                'attendance_status' => 'Clocked Out',
                'is_verified'       => false,
                'created_at'        => $now,
            ],
            [
                'username'          => 'inv_ccc',
                'full_name'         => 'ccc',
                'role'              => 'Inventory',
                'password'          => '',
                'attendance_status' => 'AWOL',
                'is_verified'       => true,
                'created_at'        => $now,
            ],
        ];

        $credentials = [];
        foreach ($users as &$user) {
            $temporary = bin2hex(random_bytes(12));
            $user['password'] = password_hash($temporary, PASSWORD_DEFAULT);
            $credentials[$user['username']] = $temporary;
        }
        unset($user);

        $this->db->table('users')->insertBatch($users);
        foreach ($credentials as $username => $temporary) {
            CLI::write('Temporary login for ' . $username . ': ' . $temporary);
        }
        CLI::write('Save these one-time credentials privately; each user should change their password.');
    }
}
