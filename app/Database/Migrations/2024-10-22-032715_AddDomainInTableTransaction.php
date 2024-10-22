<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDomainInTableTransaction extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaction', [
            'domain' => [
                'type'       => 'INT', 
                'constraint' => 5,
                'after'      => 'goal',
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
