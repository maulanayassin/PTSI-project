<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnScoreTotal extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaction', [
            'score_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,5',
                'after' => 'nilai_akhir',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction', 'score_total');
    }
}
