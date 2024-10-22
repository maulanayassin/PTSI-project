<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDomainInTableIndicator extends Migration
{
    public function up()
    {
        $this->forge->addColumn('Indicator', [
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
