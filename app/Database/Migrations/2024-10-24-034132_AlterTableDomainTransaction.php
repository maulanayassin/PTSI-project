<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableDomainTransaction extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('domain1', [
            'city_id' => [
                'name' => 'province_id',
                'type' => 'INT',
                'constraint' => '5',
                'null' => true, // Mengizinkan NULL
            ],
        ]);
        $this->forge->addColumn('domain1', [
            'city_id'       => [
                'type'       => 'INT',
                'constraint' => '5',
                'after'      => 'city_name'
            ],
        ]);
        $this->forge->modifyColumn('domain2', [
            'city_id' => [
                'name' => 'province_id',
                'type' => 'INT',
                'constraint' => '5',
                'null' => true,
            ]
        ]);
        $this->forge->addColumn('domain2', [
            'city_id'       => [
                'type'       => 'INT',
                'constraint' => '5',
                'after'      => 'city_name'
            ],
        ]);
        $this->forge->modifyColumn('domain3', [
            'city_id' => [
                'name' => 'province_id',
                'type' => 'INT',
                'constraint' => '5',
                'null' => true,
            ]
        ]);
        $this->forge->addColumn('domain3', [
            'city_id'       => [
                'type'       => 'INT',
                'constraint' => '5',
                'after'      => 'city_name'
            ],
        ]);
        $this->forge->modifyColumn('transaction', [
            'city_id' => [
                'name' => 'province_id',
                'type' => 'INT',
                'constraint' => '5',
                'null' => true,
            ]
        ]);
        $this->forge->addColumn('transaction', [
            'city_id'       => [
                'type'       => 'INT',
                'constraint' => '5',
                'after'      => 'city_name'
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
