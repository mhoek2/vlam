<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddTrainingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
                'auto_increment' => true,
            ],

            'name' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'started' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'stopped' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('trainings', true);
    }

    public function down()
    {
        $this->forge->dropTable('trainings', true);
    }
}