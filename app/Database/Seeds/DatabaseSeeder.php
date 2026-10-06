<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CustomerSeeder::class);
        $this->call(UserSeeder::class);
    }
}
