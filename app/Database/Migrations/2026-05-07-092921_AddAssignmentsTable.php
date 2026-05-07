<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddAssignmentsTable extends Migration
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

        $this->forge->createTable('assignments', true);
    }

    public function down()
    {
        $this->forge->dropTable('assignments', true);
    }
}