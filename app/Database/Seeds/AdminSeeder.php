<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'     => 'Admin3',
            'email'    => 'admin3@example.com',
            'password' => 13131313,
            'role'    => 'admin'
        ];

        // Insert data ke tabel users
        $this->db->table('users')->insert($data);
    }
}
