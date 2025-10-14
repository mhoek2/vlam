<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentEntryProperties extends Model
{
    protected $table      = 'assignment_entry_properties';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'entry_id', 'content', 'placeholder', 'sort_order'];
	
	/**
	 * Validate whether the given property ID(s) exist for the specified entry.
	 *
	 * @param array $entry The entire entry data array
	 * @param int|array|null $property_id The property ID or an array of IDs to validate.
	 *
	 * @return bool Returns true if all provided property IDs are valid, otherwise false.
	 */
	public function valid_property( $entry , $property_id )
	{
		if ( is_null($property_id) )
			return false;
		
		$conditions = [
			'entry_id' => $entry['id']
		];
		
		// not optional, make sure the (also optional) placeholder is not selected
		if (empty($entry['optional'])) {
			$conditions['placeholder !='] = 1;
		}
		
		$valid_ids = array_column( $this->where($conditions)->findAll(), 'id');

		// Check if $property_id is an array or single value
		if ( is_array($property_id) )
		{
			foreach ( $property_id as $id ) 
			{
				// If one is invalid, return false
				if ( !in_array( $id, $valid_ids ) ) 
					return false; 
			}
		
			return true;
		} 
		
		return in_array( $property_id, $valid_ids );
	}
}