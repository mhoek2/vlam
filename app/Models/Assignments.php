<?php

namespace App\Models;

use CodeIgniter\Model;

class Assignments extends Model
{
    protected $table      = 'assignments';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'meeting_id', 'name', 'sort_order', 'intro', 'outro', 'info', 'sub_assignment', 'created_at'];
	
	/**
	 * Get assignments combined with detailed metrics about referenced questions/entries and cases
	 */
    public function getDetailed( int $meeting_id )
    {
		$builder = $this->select('	
			assignments.*, 
			
			-- Get assignment count
			(SELECT COUNT(*) FROM assignment_entry
				WHERE assignment_entry.assignment_id = assignments.id
			) as assignment_entry_count,

			-- Get cases count
			(SELECT COUNT(*) FROM cases 
				WHERE cases.assignment_id = assignments.id
			) as case_count,'					 
								 
		)
		->where('assignments.meeting_id', $meeting_id)
		->groupBy('assignments.id')
		->orderBy('sort_order', 'ASC');

		return $builder->findAll();
    }
}