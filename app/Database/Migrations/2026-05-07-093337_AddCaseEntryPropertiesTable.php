<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCaseEntryPropertiesTable extends Migration
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

            'entry_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],

            'content' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('entry_id');
        
        $this->forge->createTable('case_entry_properties', true);
    }

    public function down()
    {
        $this->forge->dropTable('case_entry_properties', true);
    }
}