<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnInGradingAndAchievement extends Migration
{
    public function up()
    {
        $this->forge->addColumn('achievement', [
            'wilayah' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after' => 'city_name',
            ],
        ]);
        $this->forge->addColumn('grading', [
            'wilayah' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after' => 'city_name',
            ],
        ]);
        $this->forge->addColumn('transaction', [
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
