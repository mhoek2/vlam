<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUsersTableAddNameFields extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE users ADD COLUMN firstname TEXT NOT NULL");
        $this->db->query("ALTER TABLE users ADD COLUMN middlename TEXT NOT NULL");
        $this->db->query("ALTER TABLE users ADD COLUMN lastname TEXT NOT NULL");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE users DROP COLUMN firstname");
        $this->db->query("ALTER TABLE users DROP COLUMN middlename");
        $this->db->query("ALTER TABLE users DROP COLUMN lastname");
    }
}