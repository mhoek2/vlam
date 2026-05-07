<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddTrainingAssignmentsTable extends Migration
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

            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],

            'name' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'intro' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'outro' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'info' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'sub_assignment' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('training_id');

        $this->forge->createTable('training_assignments', true);
    }

    public function down()
    {
        $this->forge->dropTable('training_assignments', true);
    }
}