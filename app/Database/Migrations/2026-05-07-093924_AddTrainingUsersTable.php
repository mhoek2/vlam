<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTrainingUsersTable extends Migration
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

            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addUniqueKey(['training_id', 'user_id']);
        $this->forge->addUniqueKey(['user_id']);

        $this->forge->createTable('training_users', true);
    }

    public function down()
    {
        $this->forge->dropTable('training_users', true);
    }
}