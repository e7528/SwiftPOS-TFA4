<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UseUserPassword extends Migration
{
    public function up(): void
    {
        // TFA3 already contains password_hash() values. Rename the column in
        // place so existing staff passwords continue working with password_verify().
        $this->forge->modifyColumn('users', [
            'password_hash' => [
                'name'       => 'password',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->modifyColumn('users', [
            'password' => [
                'name'       => 'password_hash',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
    }
}
