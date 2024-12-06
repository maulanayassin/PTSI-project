<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyColumnInGradingAndAchievement extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('achievement', [
            'wilayah' => [
                'name'       => 'region',  // rename kolom 'wilayah' menjadi 'region'
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after'      => 'city_name',
            ],
        ]);

        // Mengubah nama kolom 'wilayah' menjadi 'region' pada tabel 'grading'
        $this->forge->modifyColumn('grading', [
            'wilayah' => [
                'name'       => 'region',  // rename kolom 'wilayah' menjadi 'region'
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after'      => 'city_name',
            ],
        ]);

        // Mengubah nama kolom 'wilayah' menjadi 'region' pada tabel 'transaction'
        $this->forge->modifyColumn('transaction', [
            'wilayah' => [
                'name'       => 'region',  // rename kolom 'wilayah' menjadi 'region'
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after'      => 'city_name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('achievement', [
            'region' => [
                'name'       => 'wilayah',
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after'      => 'city_name',
            ],
        ]);

        $this->forge->modifyColumn('grading', [
            'region' => [
                'name'       => 'wilayah',
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after'      => 'city_name',
            ],
        ]);

        $this->forge->modifyColumn('transaction', [
            'region' => [
                'name'       => 'wilayah',
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after'      => 'city_name',
            ],
        ]);
    }
}
