<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCityTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('city', [
            'kemendagri_code' => [
                'type' => 'INT',
                'constraint' => '5',
                'null' => true,
            ],
            'bps_code' => [
                'type' => 'INT',
                'constraint' => '5',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('city', 'kemendagri_code');
        $this->forge->dropColumn('city', 'bps_code');
    }
}
