<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyTableDomain extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('domain1', [
            'goal' => [
                'name'       => 'domain',
                'type'       => 'INT',
                'constraint' => 5,
            ],
        ]);
        $this->forge->modifyColumn('domain2', [
            'goal' => [
                'name'       => 'domain',
                'type'       => 'INT',
                'constraint' => 5,
            ],
        ]);
        $this->forge->modifyColumn('domain3', [
            'goal' => [
                'name'       => 'domain',
                'type'       => 'INT',
                'constraint' => 5,
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
