<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyColumnTransaction extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('transaction', [
            'domain' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,3',
            ],
        ]);
        $this->forge->dropColumn('transaction', 'value_validation');
    }

    public function down()
    {
        //
    }
}
