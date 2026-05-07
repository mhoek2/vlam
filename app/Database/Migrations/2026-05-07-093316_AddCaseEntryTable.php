<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCaseEntryTable extends Migration
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

            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],

            'name' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'info' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'case_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],

            'type' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'mcq',
                    'text_input',
                    'text_separator',
                    'mcq-2',
                    'mcq-3',
                    '',
                ],
                'null' => false,
            ],

            'optional' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('case_id');
        
        $this->forge->createTable('case_entry', true);
    }

    public function down()
    {
        $this->forge->dropTable('case_entry', true);
    }
}