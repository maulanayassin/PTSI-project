<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'city_name'    => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'city_id'       => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'indicator_id'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'year_2019'    => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'year_2020'    => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        // Menambahkan primary key
        $this->forge->addKey('id', true);

        // Membuat tabel users
        $this->forge->createTable('transaction');
    }

    public function down()
    {
        //
    }
}
