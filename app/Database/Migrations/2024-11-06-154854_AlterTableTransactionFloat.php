<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableTransactionFloat extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('transaction', [
            'value_fix' => [
                'type'       => 'float',
                'constraint' => '10,5',
                'after' => 'value',
            ],
            'growth_rate' => [
                'type'       => 'float',
                'constraint' => '10,5',
                'after' => 'value_fix',
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
