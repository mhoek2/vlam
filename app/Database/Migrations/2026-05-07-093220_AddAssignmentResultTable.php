<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAssignmentResultTable extends Migration
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

            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],

            'assignment_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],

            'entry_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],

            'property_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'comment'    => 'if set to 1, this entry relies on stored property ids in value field',
            ],

            'value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addUniqueKey(['user_id', 'assignment_id', 'entry_id']);

        $this->forge->addKey('assignment_id');
        $this->forge->addKey('entry_id');

        $this->forge->createTable('assignment_result', true);
    }

    public function down()
    {
        $this->forge->dropTable('assignment_result', true);
    }
}