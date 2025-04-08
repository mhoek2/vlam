<?php

namespace App\Models;

use CodeIgniter\Model;

class Meetings extends Model
{
    protected $table      = 'meetings';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'name', 'info', 'intro'];
	
	/**
	 * Get meetings combined with detailed metrics about referenced assignments and cases
	 */
	public function getDetailed()
	{
		$builder = $this->select('	
			meetings.*, 

			-- Get assignment count
			(SELECT COUNT(*) FROM assignments 
				WHERE assignments.meeting_id = meetings.id
			) as assignment_count,

			-- Get assignment question/entry count
			(SELECT COUNT(*) FROM assignment_entry 
				WHERE assignment_entry.assignment_id 
					IN (SELECT id FROM assignments WHERE assignments.meeting_id = meetings.id)
			) as assignment_entry_count,

			-- Get cases count
			(SELECT COUNT(*) FROM cases 
				WHERE cases.assignment_id
					IN (SELECT id FROM assignments WHERE assignments.meeting_id = meetings.id)
			) as case_count,

			-- Get case question/entry count
			(SELECT COUNT(*) FROM case_entry 
				WHERE case_entry.case_id
					IN (SELECT id FROM cases WHERE cases.assignment_id
						IN (SELECT id FROM assignments WHERE assignments.meeting_id = meetings.id)
					)
			) as case_entry_count'
		)->groupBy('meetings.id');

		return $builder->findAll();
	}
}

