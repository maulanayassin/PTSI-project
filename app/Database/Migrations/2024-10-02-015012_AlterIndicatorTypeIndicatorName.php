<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterIndicatorTypeIndicatorName extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('indicator', [
            'indicator_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255, // New size for the column
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
