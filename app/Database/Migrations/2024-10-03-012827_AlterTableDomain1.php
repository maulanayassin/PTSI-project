<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableDomain1 extends Migration
{
    public function up()
    {
        $this->forge->addColumn('domain1', [
            'indicator_name' => [
                'type'        => 'VARCHAR',
                'constraint'  => 255, 
                'after'      => 'no_indicator', // Letakkan setelah kolom tertentu
            ]
            ]);
    }
    

    public function down()
    {
        //
    }
}
