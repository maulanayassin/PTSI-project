<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnValueValidationInTransaction extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaction', [
            'value_validation' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,5',
                'after' => 'value_fix',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction', 'value_validation');
    }
}
