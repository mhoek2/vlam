<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class AssignmentController extends BaseController
{
	
	public function get_meeting( $meeting_id )
	{
		$meeting = $this->meetings->find( $meeting_id );
		
		if ( is_null($meeting) ){
			die("Meeting not found.");
		}
		
		return $meeting;
	}
	
	public function get_assignment( $assignment_id )
	{
		$assignment = $this->assignments->find($assignment_id);
		
		if ( is_null($assignment) ){
			die("Assignment not found.");
		}
		
		return $assignment;
	}
	
    public function save( $meeting_id, $assignment_id )
    {
        $user = $this->user->getUserInfo();
        $meeting = $this->get_meeting( $meeting_id );
  
        $assignment = $this->assignments->find($assignment_id);
        $assignment_entries = $this->assignmentEntry->where('assignment_id', $assignment_id)->findAll();

        $post_entries = $this->request->getPost('entries');

        if(is_null($post_entries))
        {
		    return $this->response->setJSON([
			    'status' => 'error',
                'message' => 'No entries in this assignment to save'
		    ]);
        }

        foreach($post_entries as $entry_id => $property_id )
        {
			$entry = $this->assignmentEntry->find($entry_id);
			
			$value = NULL;	// for dynamic user inputs
			
			if ($entry['type'] === "text_input") {
				$value = $property_id;
				$property_id = NULL;
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

        return $this->response->setJSON(['status' => 'success', 'message' => 'Assignemnt results stored successfully']);
    }

	
	private function is_sub_assignment( $controller_name )
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
	
    public function index( $meeting_id, $assignment_id, $is_sub = false ): string
    {  
        // Meeting
        $this->data['meeting'] = $this->get_meeting( $meeting_id ); 
		

        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		$this->data['assignment'] = $this->get_assignment($assignment_id);

        // Cases
        $this->data['cases'] = $this->cases->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();	
		
        // Entries
        $this->data['entries'] = $this->assignmentEntry->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();
        $this->data['has_entries'] = empty($this->data['entries']);
		$this->data['entry_types'] = $this->assignmentEntry->type_enum;

        // Entry properties
		$this->data['properties'] = $this->assignmentEntryProperties->orderBy('sort_order', 'ASC')->findAll();

		// Get saved user property ids and values
		// create array $saved_results with structure:
		// [entry_id] => property_id !== null ? property_id : value
		//
		$saved_properties = $this->assignmentResult->where('user_id', $this->data['user']['id'])->where('assignment_id', $assignment_id)->select(['property_id', 'entry_id', 'value'])->get()->getResultArray();
        $saved_results = array_reduce($saved_properties, function ($result, $property) {
			$result[$property['entry_id']] = !is_null($property['property_id']) ? $property['property_id'] : $property['value'];
			return $result;
		}, []);
		
        foreach( $this->data['entries'] as $id => $entry )
        {
			// set value stored for this entry, (property_id or the dynamic user input value)
			$this->data['entries'][$id]['value'] = $saved_results[$entry['id']] ?? '';	
			
			$this->data['entries'][$id]['properties'] = array();

            foreach( $this->data['properties'] as $property ){
                if ( $property['entry_id'] !== $entry['id'] )
                    continue;

                if (!isset($this->data['entries'][$id]['properties']))
                    $this->data['entries'][$id]['properties'] = array();
             
				// set selected to true if this is the saved property
				// used for eg: mcq entries
				$property['selected'] = isset($saved_results[$entry['id']]) && $saved_results[$entry['id']] === $property['id'];

                array_push( $this->data['entries'][$id]['properties'], $property );
            }
        }

		if (!$this->data['assignment']) {
			// Handle the case when the assignment is not found
			//return redirect()->to('/some-error-page')->with('error', 'Assignment not found.');
			echo "Assignment not found.";
			exit;
		}
		
		// Sub assignment
		$this->data['sub_assignment'] = $this->has_sub_assignment($this->data['assignment']);

		if ( $this->data['sub_assignment'] )
		{
			// either load it when sub page is called, or directly when no entries present
			if ($is_sub || !count($this->data['entries'])) 
			{
				$controller = $this->get_sub_assignment( $this->data['sub_assignment'] );
				
				if (!is_null($controller))
					return $controller->index( $meeting_id, $assignment_id );
			}
		}
		
		// previous and next urls
		$this->data['prev_url'] = site_url() . "meeting/" . $this->data['meeting']['id'];
		
		if ($this->data['sub_assignment'])
			$this->data['post_url'] = current_url() . "/sub";
		else
			$this->data['post_url'] = site_url() . "meeting/" . $this->data['meeting']['id'];
		
		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
        return view('front/assignment', $this->data);
    }
}
