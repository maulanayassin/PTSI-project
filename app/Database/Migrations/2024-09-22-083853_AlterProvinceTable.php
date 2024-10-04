<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterProvinceTable extends Migration
{
    public function up()
    {
        // Menambahkan kolom baru 'region' ke tabel 'province'
        $this->forge->addColumn('province', [
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
        $this->forge->dropColumn('province', 'kemendagri_code');
        $this->forge->dropColumn('province', 'bps_code');
    }
}
