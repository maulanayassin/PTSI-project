<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableTransaction3 extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('transaction', [
            'city_id' => [
                'type' => 'INT',
                'constraint' => '5',
                'null' => true, // Mengizinkan NULL
            ],
            'indicator_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true, // Mengizinkan NULL
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
