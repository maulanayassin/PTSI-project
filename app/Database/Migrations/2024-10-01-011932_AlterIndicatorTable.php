<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPSTORM_META\type;

class AlterIndicatorTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('indicator', [
            'no_indicator' => [
                'type'        => 'VARCHAR',
                'constraint'  => 100, 
                'after'      => 'id', // Letakkan setelah kolom tertentu
            ],
            'goal' => [
                'type'       => 'INT',
                'constraint' => 5, 
                'after'      => 'indicator_name', 
            ],
            'polaritas' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'after'      => 'goal',
            ],
            'tahun' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after'      => 'polaritas',
            ],
            'sumber' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after'      => 'tahun',
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
