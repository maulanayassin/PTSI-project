<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'     => 'Admin2',
            'email'    => 'admin2@example.com',
            'password' => 12121212,
        ];

        // Insert data ke tabel users
        $this->db->table('users')->insert($data);
    }
}
