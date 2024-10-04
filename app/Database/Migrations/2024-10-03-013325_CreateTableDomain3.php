<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableDomain3 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'no_indicator' =>[
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'indicator_name' => [
                'type'        => 'VARCHAR',
                'constraint'  => 255, 
                'after'      => 'no_indicator', // Letakkan setelah kolom tertentu
            ],
            'information' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'year_2019' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'year_2020' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ]
        ]);
        $this->forge->addKey('id', true);

        // Membuat tabel users
        $this->forge->createTable('domain3');
    }

    public function down()
    {
        //
    }
}
