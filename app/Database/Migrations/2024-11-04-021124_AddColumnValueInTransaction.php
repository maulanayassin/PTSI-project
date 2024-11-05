<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnValueInTransaction extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaction', [
            'value' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'after' => 'polaritas',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction', 'value');
    }
}
