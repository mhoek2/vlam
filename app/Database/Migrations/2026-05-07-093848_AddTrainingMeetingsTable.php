<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTrainingMeetingsTable extends Migration
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

            'training_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],

            'name' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],

            'info' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'intro' => [
                'type' => 'TEXT',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('training_id');

        $this->forge->createTable('training_meetings', true);
    }

    public function down()
    {
        $this->forge->dropTable('training_meetings', true);
    }
}