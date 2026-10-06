<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $customers = [
            [
                'id'            => 101,
                'full_name'     => 'Maria Santos',
                'email'         => 'maria.santos@email.com',
                'phone'         => '+63 917 123 4567',
                'password_hash' => password_hash('Customer123!', PASSWORD_DEFAULT),
                'status'        => 'Active',
                'created_at'    => $now,
            ],
            [
                'id'            => 102,
                'full_name'     => 'Juan Dela Cruz',
                'email'         => 'juan.delacruz@email.com',
                'phone'         => '+63 918 234 5678',
                'password_hash' => password_hash('Customer123!', PASSWORD_DEFAULT),
                'status'        => 'Active',
                'created_at'    => $now,
            ],
            [
                'id'            => 103,
                'full_name'     => 'Carla Reyes',
                'email'         => 'carla.reyes@email.com',
                'phone'         => '+63 920 345 6789',
                'password_hash' => password_hash('Customer123!', PASSWORD_DEFAULT),
                'status'        => 'Active',
                'created_at'    => $now,
            ],
            [
                'id'            => 104,
                'full_name'     => 'Eduardo Ramos',
                'email'         => 'eduardo.ramos@email.com',
                'phone'         => '+63 922 456 7890',
                'password_hash' => password_hash('Customer123!', PASSWORD_DEFAULT),
                'status'        => 'Active',
                'created_at'    => $now,
            ],
            [
                'id'            => 105,
                'full_name'     => 'Patricia Tan',
                'email'         => 'patricia.tan@email.com',
                'phone'         => null,
                'password_hash' => password_hash('Customer123!', PASSWORD_DEFAULT),
                'status'        => 'Active',
                'created_at'    => $now,
            ],
        ];

        $this->db->table('customers')->insertBatch($customers);
    }
}
