<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAllForeignKeys extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE assignment_entry ADD CONSTRAINT assignment_entry_assignment_id_foreign FOREIGN KEY (assignment_id) REFERENCES assignments(id) ON DELETE CASCADE");

        $this->db->query("ALTER TABLE assignment_entry_properties ADD CONSTRAINT assignment_entry_property_entry_id_foreign FOREIGN KEY (entry_id) REFERENCES assignment_entry(id) ON DELETE CASCADE");

        $this->db->query("ALTER TABLE assignment_result ADD CONSTRAINT assignment_result_assignment_id_foreign FOREIGN KEY (assignment_id) REFERENCES assignments(id) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE assignment_result ADD CONSTRAINT assignment_result_entry_id_foreign FOREIGN KEY (entry_id) REFERENCES assignment_entry(id) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE assignment_result ADD CONSTRAINT assignment_result_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE RESTRICT");

        $this->db->query("ALTER TABLE cases ADD CONSTRAINT cases_assignment_id_foreign FOREIGN KEY (assignment_id) REFERENCES assignments(id) ON DELETE CASCADE");

        $this->db->query("ALTER TABLE case_entry ADD CONSTRAINT case_entry_case_id_foreign FOREIGN KEY (case_id) REFERENCES cases(id) ON DELETE CASCADE");

        $this->db->query("ALTER TABLE case_entry_properties ADD CONSTRAINT case_entry_properties_entry_id_foreign FOREIGN KEY (entry_id) REFERENCES case_entry(id) ON DELETE CASCADE");

        $this->db->query("ALTER TABLE case_result ADD CONSTRAINT case_result_assignment_id_foreign FOREIGN KEY (assignment_id) REFERENCES assignments(id) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE case_result ADD CONSTRAINT case_result_case_id_foreign FOREIGN KEY (case_id) REFERENCES cases(id) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE case_result ADD CONSTRAINT case_result_entry_id_foreign FOREIGN KEY (entry_id) REFERENCES case_entry(id) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE case_result ADD CONSTRAINT case_result_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE RESTRICT");

        $this->db->query("ALTER TABLE training_assignments ADD CONSTRAINT training_assignments_trainings_id_foreign FOREIGN KEY (training_id) REFERENCES trainings(id) ON DELETE CASCADE ON UPDATE RESTRICT");

        $this->db->query("ALTER TABLE training_assignment_entry ADD CONSTRAINT training_assignment_entry_assignment_id_foreign FOREIGN KEY (assignment_id) REFERENCES training_assignments(id) ON DELETE CASCADE");

        $this->db->query("ALTER TABLE training_assignment_entry_properties ADD CONSTRAINT training_assignment_entry_properties_entry_id_foreign FOREIGN KEY (entry_id) REFERENCES training_assignment_entry(id) ON DELETE CASCADE");

        $this->db->query("ALTER TABLE training_assignment_result ADD CONSTRAINT training_assignment_result_assignment_id_foreign FOREIGN KEY (assignment_id) REFERENCES training_assignments(id) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE training_assignment_result ADD CONSTRAINT training_assignment_result_user_id_foreign FOREIGN KEY (user_id) REFERENCES training_users(user_id) ON DELETE CASCADE ON UPDATE RESTRICT");

        $this->db->query("ALTER TABLE training_cases ADD CONSTRAINT training_cases_assignment_id_foreign FOREIGN KEY (assignment_id) REFERENCES training_assignments(id) ON DELETE CASCADE");

        $this->db->query("ALTER TABLE training_case_entry ADD CONSTRAINT training_cases_entry_case_id_foreign FOREIGN KEY (case_id) REFERENCES training_cases(id) ON DELETE CASCADE");

        $this->db->query("ALTER TABLE training_case_entry_properties ADD CONSTRAINT training_cases_entry_properties_entry_id_foreign FOREIGN KEY (entry_id) REFERENCES training_case_entry(id) ON DELETE CASCADE");

        $this->db->query("ALTER TABLE training_case_result ADD CONSTRAINT training_case_result_assignment_id_foreign FOREIGN KEY (assignment_id) REFERENCES training_assignments(id) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE training_case_result ADD CONSTRAINT training_case_result_user_id_foreign FOREIGN KEY (user_id) REFERENCES training_users(user_id) ON DELETE CASCADE ON UPDATE RESTRICT");

        $this->db->query("ALTER TABLE training_meetings ADD CONSTRAINT training_meetings_trainings_id_foreign FOREIGN KEY (training_id) REFERENCES trainings(id) ON DELETE CASCADE ON UPDATE RESTRICT");

        $this->db->query("ALTER TABLE training_schedule ADD CONSTRAINT training_schedule_meeting_id_foreign FOREIGN KEY (meeting_id) REFERENCES training_meetings(id) ON DELETE CASCADE ON UPDATE RESTRICT");

        $this->db->query("ALTER TABLE training_users ADD CONSTRAINT training_users_trainings_id_foreign FOREIGN KEY (training_id) REFERENCES trainings(id) ON DELETE CASCADE ON UPDATE RESTRICT");
        $this->db->query("ALTER TABLE training_users ADD CONSTRAINT training_users_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE RESTRICT");

        $this->db->query("ALTER TABLE training_user_meta ADD CONSTRAINT training_user_meta_user_id_foreign FOREIGN KEY (user_id) REFERENCES training_users(user_id) ON DELETE CASCADE ON UPDATE RESTRICT");

        $this->db->query("ALTER TABLE user_meta ADD CONSTRAINT user_meta_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE RESTRICT");
    }

    public function down()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS=0");

        $this->db->query("ALTER TABLE assignment_entry DROP FOREIGN KEY assignment_entry_assignment_id_foreign");
        $this->db->query("ALTER TABLE assignment_entry_properties DROP FOREIGN KEY assignment_entry_property_entry_id_foreign");

        $this->db->query("ALTER TABLE assignment_result DROP FOREIGN KEY assignment_result_assignment_id_foreign");
        $this->db->query("ALTER TABLE assignment_result DROP FOREIGN KEY assignment_result_entry_id_foreign");
        $this->db->query("ALTER TABLE assignment_result DROP FOREIGN KEY assignment_result_user_id_foreign");

        $this->db->query("ALTER TABLE cases DROP FOREIGN KEY cases_assignment_id_foreign");

        $this->db->query("ALTER TABLE case_entry DROP FOREIGN KEY case_entry_case_id_foreign");

        $this->db->query("ALTER TABLE case_entry_properties DROP FOREIGN KEY case_entry_properties_entry_id_foreign");

        $this->db->query("ALTER TABLE case_result DROP FOREIGN KEY case_result_assignment_id_foreign");
        $this->db->query("ALTER TABLE case_result DROP FOREIGN KEY case_result_case_id_foreign");
        $this->db->query("ALTER TABLE case_result DROP FOREIGN KEY case_result_entry_id_foreign");
        $this->db->query("ALTER TABLE case_result DROP FOREIGN KEY case_result_user_id_foreign");

        $this->db->query("ALTER TABLE training_assignments DROP FOREIGN KEY training_assignments_trainings_id_foreign");

        $this->db->query("ALTER TABLE training_assignment_entry DROP FOREIGN KEY training_assignment_entry_assignment_id_foreign");

        $this->db->query("ALTER TABLE training_assignment_entry_properties DROP FOREIGN KEY training_assignment_entry_properties_entry_id_foreign");

        $this->db->query("ALTER TABLE training_assignment_result DROP FOREIGN KEY training_assignment_result_assignment_id_foreign");
        $this->db->query("ALTER TABLE training_assignment_result DROP FOREIGN KEY training_assignment_result_user_id_foreign");

        $this->db->query("ALTER TABLE training_cases DROP FOREIGN KEY training_cases_assignment_id_foreign");

        $this->db->query("ALTER TABLE training_case_entry DROP FOREIGN KEY training_cases_entry_case_id_foreign");

        $this->db->query("ALTER TABLE training_case_entry_properties DROP FOREIGN KEY training_cases_entry_properties_entry_id_foreign");

        $this->db->query("ALTER TABLE training_case_result DROP FOREIGN KEY training_case_result_assignment_id_foreign");
        $this->db->query("ALTER TABLE training_case_result DROP FOREIGN KEY training_case_result_user_id_foreign");

        $this->db->query("ALTER TABLE training_meetings DROP FOREIGN KEY training_meetings_trainings_id_foreign");

        $this->db->query("ALTER TABLE training_schedule DROP FOREIGN KEY training_schedule_meeting_id_foreign");

        $this->db->query("ALTER TABLE training_users DROP FOREIGN KEY training_users_trainings_id_foreign");
        $this->db->query("ALTER TABLE training_users DROP FOREIGN KEY training_users_user_id_foreign");

        $this->db->query("ALTER TABLE training_user_meta DROP FOREIGN KEY training_user_meta_user_id_foreign");

        $this->db->query("ALTER TABLE user_meta DROP FOREIGN KEY user_meta_user_id_foreign");

        $this->db->query("SET FOREIGN_KEY_CHECKS=1");
    }
}