<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateColumnPolaritasInTransaction extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaction', [
            'polaritas' => [
                'type'       => 'VARCHAR', 
                'constraint' => 100,
                'after'      => 'domain',
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
