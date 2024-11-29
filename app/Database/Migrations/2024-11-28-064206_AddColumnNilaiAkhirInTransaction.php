<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnNilaiAkhirInTransaction extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaction', [
            'nilai_akhir' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,5',
                'after' => 'growth_rate',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction', 'nilai_akhir');
    }
}
