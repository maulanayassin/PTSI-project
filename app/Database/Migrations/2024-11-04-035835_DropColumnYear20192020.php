<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropColumnYear20192020 extends Migration
{
    public function up()
    {
         $this->forge->dropColumn('transaction', ['year_2019', 'year_2020']);
    }

    public function down()
    {
        //
    }
}
