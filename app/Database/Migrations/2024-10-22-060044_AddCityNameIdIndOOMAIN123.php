<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCityNameIdIndOOMAIN123 extends Migration
{
    public function up()
    {
        $this->forge->addColumn('domain1', [
            'city_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'after'      => 'id'
            ],
            'city_id'       => [
                'type'       => 'INT',
                'constraint' => '5',
                'after'      => 'city_name'
            ],
        ]);
        $this->forge->addColumn('domain2', [
            'city_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'after'      => 'id'
            ],
            'city_id'       => [
                'type'       => 'INT',
                'constraint' => '5',
                'after'      => 'city_name'
            ],
        ]);
        $this->forge->addColumn('domain3', [
            'city_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'after'      => 'id'
            ],
            'city_id'       => [
                'type'       => 'INT',
                'constraint' => '5',
                'after'      => 'city_name'
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
