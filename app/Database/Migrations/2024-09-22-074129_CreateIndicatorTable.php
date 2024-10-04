<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIndicatorTable extends Migration
{
    public function up()
    {
         // Membuat struktur tabel indicator
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'indicator_name'    => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'created_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        // Menambahkan primary key
        $this->forge->addKey('id', true);

        // Membuat tabel users
        $this->forge->createTable('indicator');
    }

    public function down()
    {
        //
    }
}
