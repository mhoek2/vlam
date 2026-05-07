<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddTrainingUserMetaTable extends Migration
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

            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'value' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addUniqueKey(['user_id', 'name']);

        $this->forge->createTable('training_user_meta', true);
    }

    public function down()
    {
        $this->forge->dropTable('training_user_meta', true);
    }
}