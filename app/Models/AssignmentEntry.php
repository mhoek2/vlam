<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentEntry extends Model
{
    protected $table      = 'assignment_entry';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'type', 'name', 'sort_order', 'info', 'assignment_id'];
	
	// NOTE: 	Do not make change or remove existing type/group identifiers, this can have negative impact on existing training data.<br>
	//			If required, make sure to update the database enum and stored databse records accordingly!
	// Adding types is fine, remember to add the 'type' to the enum in the database.
    public $type_enum = [ 
        ['type' => 'mcq',               'group' => 'mcq', 	'name' => 'Keuze'],
        ['type' => 'mcq-2',             'group' => 'mcq', 	'name' => 'Keuze uit 2'],
        ['type' => 'mcq-3',             'group' => 'mcq', 	'name' => 'Keuze uit 3'],
        ['type' => 'text_input',        'group' => NULL, 	'name' => 'Text Input'], 
        ['type' => 'text_separator',    'group' => NULL, 	'name' => 'Text Separator']
    ];

	public $type_to_group;	// reference lookup-table for what group a type is part of
	public $group_counts;	// reference lookup-table to find number of types in a group
	
    public function __construct()
    {
       parent::__construct();
		
       $this->type_to_group = $this->type_to_group_table();
       $this->group_counts = $this->find_group_counts();
    }	
	
	public function find_group( $type )
	{
		// find the group identifier of a type
		
		$filtered = array_filter($this->type_enum, function($item) use ($type) {
			return $item['type'] === $type;
		});

		$filtered = array_values($filtered);
		
		return !empty($filtered) ? $filtered[0]['group'] : NULL;
	}

	public function find_group_counts()
	{
		// return table with count of types for each group
		
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
	
	public function type_to_group_table()
	{
		// return a table where key represents the type, and the value the group of the type
		
        return array_merge(...array_map(function($item) {
            return [$item['type'] => $item['group']];
        }, $this->type_enum));
	}
	
	public function valid_type( $type )
	{
		// check validity of an entry type by matching with $this->type_enum
		
		foreach ($this->type_enum as $item) {
			if ($item['type'] === $type) {
				return true;
			}
		}

		return false;
	}
	
	//
	// Query overrides:
	// provide a fail-safe for when types are removed, and database records are no longer valid
	//
    public function find($id = null)
    {
        $entry = parent::find($id);

        if ($entry && !$this->valid_type($entry['type']))
            return null;

        return $entry;
    }

    public function findAll( $limit = null, $offset = 0 )
    {
        $entries = parent::findAll($limit, $offset);

        return array_filter($entries, function ($entry) {
            return $this->valid_type($entry['type']);
        });
    }

    public function first()
	{
		$entry = parent::first();

		if ($entry && !$this->valid_type($entry['type'])) {
			return null;
		}

		return $entry;
	}	
}