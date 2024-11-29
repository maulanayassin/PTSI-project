<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnVerificationInTranasction extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaction', [
            'verification' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after' => 'value_fix',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction', 'Verification');
    }
}
