<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableNullIndOOMAIN123 extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('domain1', [
            'year_2019' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true, // Mengizinkan NULL
            ],
            'year_2020' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true, // Mengizinkan NULL
            ],
        ]);
        $this->forge->modifyColumn('domain2', [
            'year_2019' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true, // Mengizinkan NULL
            ],
            'year_2020' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true, // Mengizinkan NULL
            ],
        ]);
        $this->forge->modifyColumn('domain3', [
            'year_2019' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true, // Mengizinkan NULL
            ],
            'year_2020' => [
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
