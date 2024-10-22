<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableTransaction2 extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('transaction', [
            'city_name' => [
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
