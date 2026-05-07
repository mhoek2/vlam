<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoSeeder extends Seeder
{
    private function addUsers()
    {
        // Admin User
        $this->db->table('users')->insert([
            'username' => '3512d1b3ec7aba55b72d',
            'firstname' => 'Admin',
            'middlename' => '',
            'lastname' => 'Vlam',
            'active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $user_id = $this->db->insertID();

        $this->db->table('auth_groups_users')->insert([
            'user_id' => (int)$user_id,
            'group' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('auth_identities')->insert([
            'user_id' => (int)$user_id,
            'type' => 'email_password',
            'secret' => 'admin@vlam.nl',
            'secret2' => password_hash('xcGBN7=58$cf', PASSWORD_DEFAULT),
        ]);

        // Demo participant
        $this->db->table('users')->insert([
            'username' => '2612d1b3ec7aba55b72e',
            'firstname' => 'User',
            'middlename' => '',
            'lastname' => 'Vlam',
            'active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $user_id = $this->db->insertID();

        $this->db->table('auth_groups_users')->insert([
            'user_id' => (int)$user_id,
            'group' => 'user',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('auth_identities')->insert([
            'user_id' => (int)$user_id,
            'type' => 'email_password',
            'secret' => 'user@vlam.nl',
            'secret2' => password_hash('9$Di524Gw%)f', PASSWORD_DEFAULT),
        ]);
    }

    private function addMeetings()
    {
        $data = [
            ['id' => 1, 'name' => 1, 'info' => 'Bijeenkomst 1', 'intro' => '<p><i>Intro</i></p>'],
            ['id' => 2, 'name' => 2, 'info' => 'Bijeenkomst 2', 'intro' => '<p>Intro</p>'],
            ['id' => 3, 'name' => 3, 'info' => 'Bijeenkomst 3', 'intro' => '<p>Intro</p>'],
            ['id' => 4, 'name' => 4, 'info' => 'Bijeenkomst 4', 'intro' => '<p>Intro</p>'],
            ['id' => 5, 'name' => 5, 'info' => 'Bijeenkomst 5', 'intro' => '<p>Intro</p>'],
            ['id' => 6, 'name' => 6, 'info' => 'Bijeenkomst 6', 'intro' => '<p>Intro</p>'],
        ];

        $this->db->table('meetings')->insertBatch($data);
    }

    private function addAssignments()
    {
        $data = [
            [
                'id' => 1,
                'meeting_id' => 1,
                'sort_order' => 0,
                'name' => 'Opdracht 1',
                'intro' => '<p>Lorem ipsum...</p>',
                'outro' => '<p>asdasd</p>',
                'info' => 'Herken de werkervaring',
                'sub_assignment' => 'ExamplePostSaveController',
                'created_at' => '2025-02-17 19:05:20',
            ],
            [
                'id' => 32,
                'meeting_id' => 1,
                'sort_order' => 2,
                'name' => 'Opdracht 2',
                'intro' => '<h1>De tekst die de opdracht verder uitlegt.</h1>',
                'outro' => '',
                'info' => 'Informatie over de opdracht',
                'sub_assignment' => 'default',
                'created_at' => '2025-09-03 11:34:57',
            ],
        ];

        $this->db->table('assignments')->insertBatch($data);
    }

    private function addAssignmentEntries()
    {
        $data = [
            ['id' => 98, 'sort_order' => 1, 'name' => 'Question 1', 'info' => '', 'assignment_id' => 1, 'type' => 'mcq', 'optional' => 0],
            ['id' => 99, 'sort_order' => 2, 'name' => 'Question 2', 'info' => '', 'assignment_id' => 1, 'type' => 'mcq-2', 'optional' => 1],
            ['id' => 105, 'sort_order' => 0, 'name' => 'Vraag 1', 'info' => '', 'assignment_id' => 32, 'type' => 'mcq-2', 'optional' => 0],
            ['id' => 106, 'sort_order' => 1, 'name' => 'Vraag 2', 'info' => '', 'assignment_id' => 32, 'type' => 'mcq', 'optional' => 0],
        ];

        $this->db->table('assignment_entry')->insertBatch($data);
    }

    private function addAssignmentEntryProperties()
    {
        $data = [
            ['id' => 141, 'entry_id' => 98, 'content' => 'Ja', 'placeholder' => 0, 'sort_order' => 1],
            ['id' => 142, 'entry_id' => 98, 'content' => 'Nee', 'placeholder' => 0, 'sort_order' => 2],
            ['id' => 143, 'entry_id' => 99, 'content' => 'Ja', 'placeholder' => 0, 'sort_order' => 1],
            ['id' => 154, 'entry_id' => 99, 'content' => 'Nee', 'placeholder' => 0, 'sort_order' => 2],
            ['id' => 155, 'entry_id' => 105, 'content' => 'antwoord 1', 'placeholder' => 0, 'sort_order' => 0],
            ['id' => 156, 'entry_id' => 105, 'content' => 'antwoord 2', 'placeholder' => 0, 'sort_order' => 1],
            ['id' => 159, 'entry_id' => 105, 'content' => 'antwoord 3', 'placeholder' => 0, 'sort_order' => 2],
            ['id' => 160, 'entry_id' => 106, 'content' => 'ja', 'placeholder' => 0, 'sort_order' => 0],
            ['id' => 161, 'entry_id' => 106, 'content' => 'nee', 'placeholder' => 0, 'sort_order' => 1],
            ['id' => 185, 'entry_id' => 98, 'content' => 'Kies een optie', 'placeholder' => 1, 'sort_order' => 0],
            ['id' => 186, 'entry_id' => 99, 'content' => 'Kies een optie', 'placeholder' => 1, 'sort_order' => 0],
        ];

        $this->db->table('assignment_entry_properties')->insertBatch($data);
    }

    private function addCases()
    {
        $this->db->table('cases')->insert([
            'id' => 1,
            'assignment_id' => 1,
            'sort_order' => 0,
            'name' => 'Casus 1',
            'intro' => '<p>Intro</p>',
            'outro' => '<p>Ouro</p>',
            'info' => 'Dit is casus 1',
            'complete_action' => 'default',
            'created_at' => '2026-03-30 11:24:13',
        ]);
    }

    private function addCaseEntries()
    {
        $this->db->table('case_entry')->insertBatch([
            ['id' => 1, 'sort_order' => 0, 'name' => 'Vraag 1', 'info' => '', 'case_id' => 1, 'type' => 'mcq', 'optional' => 0],
            ['id' => 2, 'sort_order' => 1, 'name' => 'Vraag 2', 'info' => '', 'case_id' => 1, 'type' => 'mcq-2', 'optional' => 1],
        ]);
    }

    private function addCaseEntryProperties()
    {
        $this->db->table('case_entry_properties')->insertBatch([
            ['id' => 1, 'entry_id' => 1, 'content' => 'Ja', 'sort_order' => 0],
            ['id' => 2, 'entry_id' => 1, 'content' => 'Nee', 'sort_order' => 1],
            ['id' => 3, 'entry_id' => 1, 'content' => 'Misschien', 'sort_order' => 2],
            ['id' => 4, 'entry_id' => 2, 'content' => 'Blauw', 'sort_order' => 0],
            ['id' => 5, 'entry_id' => 2, 'content' => 'Rood', 'sort_order' => 1],
            ['id' => 6, 'entry_id' => 2, 'content' => 'Groen', 'sort_order' => 2],
            ['id' => 7, 'entry_id' => 2, 'content' => 'Geel', 'sort_order' => 3],
            ['id' => 8, 'entry_id' => 2, 'content' => 'Paars', 'sort_order' => 4],
        ]);
    }

    public function run()
    {
        $this->addUsers();
        $this->addMeetings();
        $this->addAssignments();
        $this->addAssignmentEntries();
        $this->addAssignmentEntryProperties();
        $this->addCases();
        $this->addCaseEntries();
        $this->addCaseEntryProperties();
    }
}