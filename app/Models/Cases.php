<?php

namespace App\Models;

use CodeIgniter\Model;

class Cases extends Model
{
    protected $table      = 'cases';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'assignment_id', 'name', 'sort_order', 'intro', 'outro', 'info', 'complete_action', 'created_at'];
	
	/**
	 * Get cases combined with detailed metrics about referenced questions/entries
	 */
    public function getDetailed( int $assignment_id )
    {
		$builder = $this->select('	
			cases.*, 
			
			-- Get cases entry count
			(SELECT COUNT(*) FROM case_entry
				WHERE case_entry.case_id = cases.id
			) as case_entry_count,'					 					 
		)
		->where('cases.assignment_id', $assignment_id)
		->groupBy('cases.id')
		->orderBy('sort_order', 'ASC');

		return $builder->findAll();
    }
}