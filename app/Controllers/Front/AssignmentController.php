<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class AssignmentController extends BaseController
{
	private function is_sub_assignment( string $controller_name )
	{
		$controller_class = "App\Controllers\Front\SubAssignments\\" . $controller_name;
		
		if (is_null($controller_name) || $controller_name === 'default')
			return NULL;
		
		if (class_exists($controller_class))
			return $controller_name;
	}
	
	private function has_sub_assignment( $assignment )
	{
		if (is_null($assignment))
			return false;
		
		return $this->is_sub_assignment( $assignment['sub_assignment'] ) ? $assignment['sub_assignment'] : false;
	}
	
	private function get_sub_assignment( $controller_name )
	{
		$controller_class = "App\Controllers\Front\SubAssignments\\" . $controller_name;
		
		// redundant check validity
		if ( !$this->is_sub_assignment( $controller_name ) )	
			return NULL;
		
		if (class_exists($controller_class)) {
			$request = \Config\Services::request();
			$response = \Config\Services::response();
			$logger = \Config\Services::logger();

			$controller = new $controller_class();
			$controller->initController( $request, $response, $logger );
			
			return $controller;
		} 
		
		die('can not load sub assignment');
	}
	
    public function save( int $meeting_id, int $assignment_id )
    {
		$warnings = [];
		
        $user = $this->user->getUserInfo();
        $meeting = $this->get_meeting( $meeting_id );
  
        $assignment = $this->get_assignment($assignment_id);
        $assignment_entries = $this->assignmentEntry->where('assignment_id', $assignment_id)->findAll();

        $post_entries = $this->request->getPost('entries');

        if(is_null($post_entries))
        {
		    return $this->response->setJSON([
			    'status' 			=> 'error',
                'message' 			=> 'No entries in this assignment to save',
				'new_csrf_token' 	=> csrf_hash(),
		    ]);
        }

        foreach($post_entries as $entry_id => $property_id )
        {
			$entry = $this->assignmentEntry->find($entry_id);
			$entry_type_group = $this->assignmentEntry->find_group($entry['type']);

			$value = NULL;	// stores list of property ids (integer list), or dynamic user-defined inputs (strings)
			
			// check if entry type exists!
			if (!$this->assignmentEntry->valid_type($entry['type']))
			{
				array_push( $warnings, "entry type '".$entry['type']."' does not exist!" );
				continue;
			}
			
			if ($entry['type'] === "text_input") {
				$value = $property_id;
				$property_id = NULL;
			}
			
			if ( $entry_type_group == 'mcq' )
			{
				// mark -1 for invalid/empty
				if (is_null($property_id))
					$property_id = -1;
				
				// validate property ids
				else if ( !$this->assignmentEntryProperties->valid_property($entry_id, $property_id) )
				{
					array_push( $warnings, "Invalid entry property! .. what are you trying to do mate?" );
					continue;
				}

				if ( is_array($property_id) )
				{
					if ( !preg_match('/^mcq-(\d+)$/', $entry['type'], $matches) ) {
						array_push( $warnings, "entry type '".$entry['type']."' does not match valid multi-selectable type of 'mcq-(int)'.." );
						continue;
					}
					
					if ( count($property_id) > (int)$matches[1] )
					{
						array_push( $warnings, "count does not match with entry! .. what are you trying to do mate?" );
						continue;
					}
				
					// use array_slice as fail-safe, for non matching property-counts
					$value = json_encode(array_map('intval', array_slice($property_id, 0, (int)$matches[1])));	// store as integers
				}
				else
					$value = json_encode([(int)$property_id]);	// store as integer
					
				$property_id = 1; // used to check if value is list of properties or a user-defined value
			}
			
			$this->assignmentResult->replace([ 
				'user_id' 		=> $user['id'], 
				'assignment_id' => $assignment_id,
				'entry_id' 		=> $entry_id,
				'property_id' 	=> $property_id,
				'value'			=> $value
				]
			);
        }

		return $this->response->setJSON([
			'status' 			=> 'success', 
			'message' 			=> 'Assignemnt results stored successfully', 
			'warnings'			=> $warnings,
			'new_csrf_token' 	=> csrf_hash(),
		]);
    }
	
	private function fetch_entry_properties( array $properties, array &$saved_results, array &$entry )
	{		
		// set stored value for this entry, (property_id or the dynamic user input value)
		$entry['value'] = $saved_results[$entry['id']] ?? '';			
		$entry['properties'] = [];
		
		foreach( $properties as $property )
		{
			if ( $property['entry_id'] !== $entry['id'] )
				continue;

			// Mark property as selected if it exists in saved results - used for eg: mcq entry group (selects)
			$property['selected'] = isset($saved_results[$entry['id']]) && is_array($saved_results[$entry['id']]) && 
				in_array($property['id'], $saved_results[$entry['id']]);

			array_push( $entry['properties'], $property );
		}
	}
	
	private function fetch_entries( int $assignment_id )
	{
        // Entries
        $this->data['entries'] = $this->assignmentEntry->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();
        $this->data['has_entries'] = empty($this->data['entries']);
		$this->data['entry_types'] = $this->assignmentEntry->type_enum;

        // Entry properties
		$this->data['properties'] = $this->assignmentEntryProperties->orderBy('sort_order', 'ASC')->findAll();
		
		// Get saved user property ids and values
		// create array $saved_results with structure:
		// [entry_id] => property_id !== null) ? (array)json_decode(property_id) : value
		// if property_id is set to 1 (mcq), value contains integer list of selected property_id's
		$saved_properties = $this->assignmentResult->where('user_id', $this->data['user']['id'])->where('assignment_id', $assignment_id)->select(['property_id', 'entry_id', 'value'])->get()->getResultArray();
        $saved_results = array_reduce($saved_properties, function ($result, $property) {
			$result[$property['entry_id']] = !is_null($property['property_id']) ? json_decode($property['value'], true) : $property['value'];
			return $result;
		}, []);
		
        foreach( $this->data['entries'] as $id => &$entry )
        {
			// should never happen!
			// this is a fail-safe, assignmentEntry Model has query overrides.
			if (!$this->assignmentEntry->valid_type($entry['type'])) 
			{
				unset($this->data['entries'][$id]);
				continue;
			}

			$this->fetch_entry_properties( $this->data['properties'], $saved_results, $entry );
        }
	}
	
    public function index( int $meeting_id, int $assignment_id, bool $is_sub = false ): string
    {  
        // Meeting
        $this->data['meeting'] = $this->get_meeting( $meeting_id ); 
        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		$this->data['assignment'] = $this->get_assignment($assignment_id);

        // Cases
        $this->data['cases'] = $this->cases->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();	
		
		// Fetch entries and properties with saved values
		$this->fetch_entries( $assignment_id );
	
		// Sub assignment
		$this->data['sub_assignment'] = $this->has_sub_assignment($this->data['assignment']);

		if ( $this->data['sub_assignment'] )
		{
			// either load it when sub page is requested, or directly when no entries exist
			if ($is_sub || !count($this->data['entries'])) 
			{
				$controller = $this->get_sub_assignment( $this->data['sub_assignment'] );
				
				if (!is_null($controller))
					return $controller->index( $meeting_id, $assignment_id );
			}
		}
		
		// previous and next urls
		$this->data['prev_url'] = base_url(route_to('front.meeting', $meeting_id));
		
		if ($this->data['sub_assignment'])
			$this->data['post_url'] = current_url() . "/sub";
		else
			$this->data['post_url'] = base_url(route_to('front.meeting', $meeting_id));
		
		
		$this->data['edit_url'] = $this->get_edit_route('admin.assignment', $assignment_id);
		
		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
        return view('front/assignment', $this->data);
    }
}
