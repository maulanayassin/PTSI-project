<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EditTableColoumn extends Migration
{
    public function up()
    {
        $this->forge->addColumn('indicator', [
            'rating' => [
                'type'       => 'VARCHAR',
                'constraint' => 20, 
                'after'      => 'indicator_name', // Letakkan setelah kolom tertentu
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
