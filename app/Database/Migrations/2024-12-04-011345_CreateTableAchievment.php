<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCalculation extends Migration
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
            'year' =>[
                'type' => 'INT',
                'constraint' => 5,
            ],
            'city_name' => [
                'type'        => 'VARCHAR',
                'constraint'  => 100, 
            ],
            'city_id'   => [
                'type'        => 'INT',
                'constraint'  => 5,
            ],
            'province_name' => [
                'type'        => 'VARCHAR',
                'constraint'  => 100, 
            ],
            'province_id'   => [
                'type'        => 'INT',
                'constraint'  => 5,
            ],
            'domain1' => [
                'type' => 'DECIMAL',
                'constraint' => '10,5',
            ],
            'domain2' => [
                'type' => 'DECIMAL',
                'constraint' => '10,5',
            ],
            'domain3A' => [
                'type' => 'DECIMAL',
                'constraint' => '10,5',
            ],
            'domain3B' => [
                'type' => 'DECIMAL',
                'constraint' => '10,5',
            ],
            'rating' => [
                'type' => 'DECIMAL',
                'constraint' => '10,5',
            ],
            'champion_grade' => [
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
        $this->forge->createTable('grading');
    }

    public function down()
    {
        //
    }
}
