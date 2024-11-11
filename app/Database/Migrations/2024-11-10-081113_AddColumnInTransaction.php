<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnInTransaction extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaction', [
            'indicator_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '225',
                'after' => 'indicator_id',
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
