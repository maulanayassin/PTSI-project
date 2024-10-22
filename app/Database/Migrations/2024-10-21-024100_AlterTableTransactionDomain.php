<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableTransactionDomain extends Migration
{
    public function up()
    {
        $this->forge->addColumn('domain1', [
            'goal' => [
                'type'       => 'INT',
                'constraint' => 5,   
                'after'      => 'no_indicator', // Letakkan setelah kolom tertentu
            ]
            ]);
        $this->forge->addColumn('domain2', [
            'goal' => [
                'type'       => 'INT',
                'constraint' => 5, 
                'after'      => 'no_indicator', // Letakkan setelah kolom tertentu
            ]
            ]);
        $this->forge->addColumn('domain3', [
            'goal' => [
                'type'       => 'INT',
                'constraint' => 5, 
                'after'      => 'no_indicator', // Letakkan setelah kolom tertentu
            ]
            ]);
            $this->forge->addColumn('transaction', [
            'goal' => [
                'type'       => 'INT',
                'constraint' => 5, 
                'after'      => 'indicator_id', // Letakkan setelah kolom tertentu
            ]
            ]);
    }

    public function down()
    {
        //
    }
}
