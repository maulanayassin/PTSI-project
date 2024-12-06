<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnInCity extends Migration
{
    public function up()
    {
        $this->forge->addColumn('city', [
            'wilayah' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after' => 'city_name',
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
