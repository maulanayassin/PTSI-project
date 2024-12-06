<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableGrading extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('grading', [
            'year' =>[
                'type' => 'INT',
                'constraint' => 5,
                'null' => true,
            ],
            'city_name' => [
                'type'        => 'VARCHAR',
                'constraint'  => 100, 
                'null' => true,
            ],
            'city_id'   => [
                'type'        => 'INT',
                'constraint'  => 5,
                'null' => true,
            ],
            'province_name' => [
                'type'        => 'VARCHAR',
                'constraint'  => 100, 
                'null' => true,
            ],
            'province_id'   => [
                'type'        => 'INT',
                'constraint'  => 5,
                'null' => true,
            ],
            'domain1' => [
                'type' => 'DECIMAL',
                'constraint' => '10,5',
                'null' => true,
            ],
            'domain2' => [
                'type' => 'DECIMAL',
                'constraint' => '10,5',
                'null' => true,
            ],
            'domain3A' => [
                'type' => 'DECIMAL',
                'constraint' => '10,5',
                'null' => true,
            ],
            'domain3B' => [
                'type' => 'DECIMAL',
                'constraint' => '10,5',
                'null' => true,
            ],
            'rating' => [
                'type' => 'DECIMAL',
                'constraint' => '10,5',
                'null' => true,
            ],
            'champion_grade' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
