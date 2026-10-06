<?php

namespace App\Database\Seeds;

use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;

/**
 * Explicit opt-in credential reset for an existing database whose passwords are unknown.
 * Running this invalidates every previous staff password. Run only from the CLI.
 */
class ResetUserPasswordsSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->db->table('users')->get()->getResultArray() as $user) {
            $temporary = bin2hex(random_bytes(12));
            $this->db->table('users')->where('id', $user['id'])->update([
                'password' => password_hash($temporary, PASSWORD_DEFAULT),
            ]);
            CLI::write('Temporary login for ' . $user['username'] . ': ' . $temporary);
        }

        CLI::write('Store these credentials privately and change passwords after login.');
    }
}
