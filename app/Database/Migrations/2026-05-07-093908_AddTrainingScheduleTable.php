<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTrainingScheduleTable extends Migration
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

            'meeting_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],

            'date' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['training_id', 'meeting_id']);

        $this->forge->addKey('meeting_id');

        $this->forge->createTable('training_schedule', true);
    }

    public function down()
    {
        $this->forge->dropTable('training_schedule', true);
    }
}