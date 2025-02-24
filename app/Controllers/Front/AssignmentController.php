<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class AssignmentController extends BaseController
{
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
        $meeting = $this->meetings->find( $meeting_id );
  
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
			$this->assignmentResult->replace([ 
				'user_id' 		=> $user['id'], 
				'assignment_id' => $assignment_id,
				'entry_id' 		=> $entry_id,
				'property_id' 	=> $property_id,
				]
			);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Assignemnt results stored successfully']);
    }

    public function index( $meeting_id, $assignment_id ): string
    {  
        // Meeting
        $this->data['meeting'] = $this->meetings->find( $meeting_id );
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

		// Get saved user property ids
		$selected_properties = array_column(
			 $this->assignmentResult->where('user_id', $this->data['user']['id'])->where('assignment_id', $assignment_id)->select('property_id')->get()->getResultArray(), 
			'property_id'
		);
       
        foreach( $this->data['entries'] as $id => $entry )
        {

			$this->data['entries'][$id]['properties'] = array();
			
            foreach( $this->data['properties'] as $property ){
                if ( $property['entry_id'] !== $entry['id'] )
                    continue;

                if (!isset($this->data['entries'][$id]['properties']))
                    $this->data['entries'][$id]['properties'] = array();
             
                $property['selected'] = in_array($property['id'], $selected_properties);

                array_push( $this->data['entries'][$id]['properties'], $property );
            }
        }

		if (!$this->data['assignment']) {
			// Handle the case when the assignment is not found
			//return redirect()->to('/some-error-page')->with('error', 'Assignment not found.');
			echo "Assignment not found.";
			exit;
		}

		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
        return view('front/assignment', $this->data);
    }
}
