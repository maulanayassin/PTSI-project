<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableTransactionYear extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('transaction', [
            'year_2019' => [
                'type'  => 'VARCHAR',
                'constraint' => '100',
                'null'      => true,
            ],
            'year_2020' => [
                'type'  => 'VARCHAR',
                'constraint' => '100',
                'null'      => true,
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
