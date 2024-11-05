<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnGrowth extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaction', [
            'value_fix' => [
                'type'       => 'float',
                'constraint' => '10,2',
                'after' => 'value',
            ],
            'growth_rate' => [
                'type'       => 'float',
                'constraint' => '10,2',
                'after' => 'value_fix',
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
