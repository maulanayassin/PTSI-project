<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableGoal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'goal' =>[
                'type' => 'INT',
                'constraint' => 5,
            ],
            'goal_name' => [
                'type'        => 'VARCHAR',
                'constraint'  => 100, 
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('goal');
    }

    public function down()
    {
        //
    }
}
