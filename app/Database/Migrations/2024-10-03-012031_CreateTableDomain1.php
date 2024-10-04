<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableDomain1 extends Migration
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
        $this->forge->createTable('domain1');
    }

    public function down()
    {
        //
    }
}
