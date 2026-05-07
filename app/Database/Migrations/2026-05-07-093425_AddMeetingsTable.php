<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMeetingsTable extends Migration
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

        $this->forge->createTable('meetings', true);
    }

    public function down()
    {
        $this->forge->dropTable('meetings', true);
    }
}