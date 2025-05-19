<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingMeetings extends Model
{
    protected $table      = 'training_meetings';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'training_id', 'name', 'info', 'intro'];
	
	/**
	 * Get training meetings combined with detailed metrics about referenced training assignments and cases
	 */
	public function getDetailed()
	{
		$builder = $this->select('	
			training_meetings.*, 

			-- Get assignment count
			(SELECT COUNT(*) FROM assignments 
				WHERE training_assignments.meeting_id = training_meetings.id
			) as assignment_count,

			-- Get assignment question/entry count
			(SELECT COUNT(*) FROM assignment_entry 
				WHERE assignment_entry.assignment_id 
					IN (SELECT id FROM training_assignments WHERE training_assignments.meeting_id = training_meetings.id)
			) as assignment_entry_count,

			-- Get cases count
			(SELECT COUNT(*) FROM cases 
				WHERE cases.assignment_id
					IN (SELECT id FROM training_assignments WHERE training_assignments.meeting_id = training_meetings.id)
			) as case_count,

			-- Get case question/entry count
			(SELECT COUNT(*) FROM case_entry 
				WHERE case_entry.case_id
					IN (SELECT id FROM cases WHERE cases.assignment_id
						IN (SELECT id FROM training_assignments WHERE training_assignments.meeting_id = training_meetings.id)
					)
			) as case_entry_count'
		)->groupBy('meetings.id');

		return $builder->findAll();
	}
}

