<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentEntry extends Model
{
    protected $table      = 'assignment_entry';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'sort_order', 'name', 'info', 'assignment_id', 'type', 'optional'];
	
	/**
	 * This is how question/entry types are defined.
	 *
	 * <em><p style="color:red"><b>IMPORTANT!</b> 
	 * Do not change or remove existing type/group 'type' identifiers. This can have negative impact on existing training data.
	 * If required, <u>make sure</u> to update the database enum and all database records that reference that type!
	 * </p></em>
	 * When adding types, <u>make sure</u> to add the new 'type' to the enum in the database.
	 */
    public $type_enum = [ 
        ['type' => 'mcq',               'group' => 'mcq', 	'name' => 'Keuze',			'is_input' => true],
        ['type' => 'mcq-2',             'group' => 'mcq', 	'name' => 'Keuze uit 2',	'is_input' => true],
        ['type' => 'mcq-3',             'group' => 'mcq', 	'name' => 'Keuze uit 3',	'is_input' => true],
        ['type' => 'text_input',        'group' => NULL, 	'name' => 'Text Input',		'is_input' => true], 
        ['type' => 'text_separator',    'group' => NULL, 	'name' => 'Text Separator',	'is_input' => false]
    ];

	public $type_to_group;	// reference lookup-table for what group a type is part of
	public $group_counts;	// reference lookup-table to find number of types in a group
	
    public function __construct()
    {
       parent::__construct();
		
       $this->type_to_group = $this->type_to_group_table();
       $this->group_counts = $this->find_group_counts();
    }	
	
	/**
	 * Return the group identifier of a type
	 */
	public function find_group( $type )
	{
		// find the group identifier of a type
		
		$filtered = array_filter($this->type_enum, function($item) use ($type) {
			return $item['type'] === $type;
		});

		$filtered = array_values($filtered);
		
		return !empty($filtered) ? $filtered[0]['group'] : NULL;
	}

	/**
	 * returns an array with number of types per group
	 */
	public function find_group_counts() : array
	{
		$group_counts = [];

		foreach ($this->type_enum as $item) {
			$group = $item['group'] ?? 'null';
			
			if (isset($group_counts[$group]))
				$group_counts[$group]++;
			
			else
				$group_counts[$group] = 1;
		}

		return $group_counts;
	}
	
	/**
	 * return an array where key represents the type, and the value the group of the type
	 */	
	public function type_to_group_table() : array
	{
        return array_merge(...array_map(function($item) {
            return [$item['type'] => $item['group']];
        }, $this->type_enum));
	}
	
	/**
	 * check validity of an entry type by matching with $this->type_enum
	 */	
	public function valid_type( $type ) : bool
	{
		foreach ($this->type_enum as $item) {
			if ($item['type'] === $type) {
				return true;
			}
		}

		return false;
	}
	
	/**
	 * Returns true if entry type explicitly requires user input (question only)
	 */	
	public function user_input_type( $type ) : bool
	{
		foreach ($this->type_enum as $item) {
			if ($item['type'] === $type && $item['is_input']) {
				return true;
			}
		}

		return false;
	}
	
	/**
	 * Returns array of entries that explicitly require user input (questions only)
	 */	
	public function findAllUserInputs( $limit = null, $offset = 0 ) : array
	{
        $entries = parent::findAll($limit, $offset);

        return array_filter($entries, function ($entry) {
            return $this->user_input_type($entry['type']);
        });
	}
		
	//
	// Query overrides:
	// provide a fail-safe for when types are removed, and database records are no longer valid
	//

	/**
	 * Override: Returns null if type is invalid
	 */	
    public function find($id = null)
    {
        $entry = parent::find($id);

        if ($entry && !$this->valid_type($entry['type']))
            return null;

        return $entry;
    }

	/**
	 * Override: Do not include invalid types
	 */
    public function findAll( $limit = null, $offset = 0 ) : array
    {
        $entries = parent::findAll($limit, $offset);

        return array_filter($entries, function ($entry) {
            return $this->valid_type($entry['type']);
        });
    }

	/**
	 * Override: Returns null if type is invalid
	 */	
    public function first()
	{
		$entry = parent::first();

		if ($entry && !$this->valid_type($entry['type'])) {
			return null;
		}

		return $entry;
	}	
}