<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUploadsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'null'           => false,
                'auto_increment' => true,
            ],
            'global' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
            'user_id' => [
                'type'     => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null'     => false,
            ],
            'path' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'filename' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'extension' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'mime_type' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'bytes' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('uploads', true);
    }

    public function down()
    {
        $this->forge->dropTable('uploads', true);
    }
}