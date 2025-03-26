<?php

namespace App\Models;

use CodeIgniter\Model;

class CaseEntryProperties extends Model
{
    protected $table      = 'case_entry_properties';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'entry_id', 'content', 'sort_order'];
	
	/**
	 * Validate whether the given property ID(s) exist for the specified entry.
	 *
	 * @param int $entry_id The ID of the entry to check against.
	 * @param int|array|null $property_id The property ID or an array of IDs to validate.
	 *
	 * @return bool Returns true if all provided property IDs are valid, otherwise false.
	 */
	public function valid_property( int $entry_id, $property_id )
	{
		if ( is_null($property_id) )
			return false;
		
		$valid_ids = array_column( $this->where('entry_id', $entry_id)->findAll(), 'id');

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