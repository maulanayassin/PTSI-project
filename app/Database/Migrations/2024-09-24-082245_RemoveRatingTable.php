<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveRatingTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('indicator', 'rating');
    }

    public function down()
    {
        //
    }
}
