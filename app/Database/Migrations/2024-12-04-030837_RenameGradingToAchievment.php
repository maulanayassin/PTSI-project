<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameGradingToAchievment extends Migration
{
    public function up()
    {
        $this->forge->renameTable('grading', 'achievement');
    }

    public function down()
    {
        $this->forge->renameTable('achievement', 'grading');
    }
}
