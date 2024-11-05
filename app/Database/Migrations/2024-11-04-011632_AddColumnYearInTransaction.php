<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnYearInTransaction extends Migration
{
    public function up()
    {
         $this->forge->addColumn('transaction', [
            'year' => [
                'type' => 'INT',
                'constraint' => 5,
                'after' => 'id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction', 'year');
    }
}
