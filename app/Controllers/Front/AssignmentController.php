<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

use App\Models\AssignmentEntry;
use App\Models\AssignmentEntryProperties;

use App\Models\AssignmentResult;
use App\Models\AssignmentResultEntry;

class AssignmentController extends BaseController
{
    public function __construct() {
        $this->assignmentEntry = new assignmentEntry();
        $this->assignmentEntryProperties = new AssignmentEntryProperties();

        $this->assignmentResult = new AssignmentResult();
        $this->assignmentResultEntry = new AssignmentResultEntry();
    }

    public function save( $meeting_id, $assignment_id )
    {
        $result_id = -1;

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

        // find any previous submitted results
        //
        // Note: Could switch db column 'name' to UNIQUE amd use ->replace(), 
        // wanted to try both methods in codeigniter though..
        $exists = $this->assignmentResult->where([
            'user_id' => $user['id'],
            'meeting' => $meeting['name']."_".$meeting['info'],
            'name' => $assignment['name']
        ])->first();

        // First time submission, create a new entry for this assignment
        if(is_null($exists)) {
		    $this->assignmentResult->insert([
			    'user_id' => $user['id'], 
			    'meeting' => $meeting['name']."_".$meeting['info'],
			    'name' => $assignment['name'], 
			    'info' => $assignment['info'] ]
		    );
            
            $result_id = $this->assignmentEntry->insertID();
		}
        // A record exists, meaning the entries are being updated
        else {
            $result_id = $exists['id'];
        }

        if( $result_id < 0 ) {
		    return $this->response->setJSON([
			    'status' => 'error',
                'message' => 'Could not insert assignment result'
		    ]);
        }

        $getDBEntryById = function($entries, $id) {
            // Use array_filter to find the entry with the matching id
            $filteredEntries = array_filter($entries, function($entry) use ($id) {
                return (int)$entry['id'] === $id;
            });

            // Return the first match or null if no match is found
            return reset($filteredEntries) ?: null;
        };

        // Store or update entries
        // Use replace function with UNIQUE 
        foreach($post_entries as $entry_id => $property_name )
        {
            $entry = $getDBEntryById($assignment_entries, $entry_id);

            if (!is_null($entry)) 
            {
		        $this->assignmentResultEntry->replace([ 
			        'result_id' => $result_id, 
			        'name' => $entry['name'],
			        'value' => $property_name,
			        'type' => $entry['type'],
                    ]
		        );
            }
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
		$this->data['assignment'] = $this->assignments->find($assignment_id);

        // Cases
        $this->data['cases'] = $this->cases->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();	
		
        // Entries
        $this->data['entries'] = $this->assignmentEntry->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();
		$this->data['entry_types'] = $this->assignmentEntry->type_enum;

        // Entry properties
		$this->data['properties'] = $this->assignmentEntryProperties->orderBy('sort_order', 'ASC')->findAll();

        // Saved results
        $this->data['result'] = $this->assignmentResult->where([
            'user_id' 	=> $this->data['user']['id'],
            'name' 		=> $this->data['assignment']['name']
        ])->first();
        if(!is_null($this->data['result']))
        {
            $this->data['result']['entries'] = $this->assignmentResultEntry->where('result_id', $this->data['result']['id'])->findAll();
        }

        $getSavedPropertyByName = function($entries, $name) {
            // Use array_filter to find the entry with the matching id
            $filteredEntries = array_filter($entries, function($entry) use ($name) {
                return $entry['name'] === $name;
            });

            // Return the first match or null if no match is found
            return reset($filteredEntries) ?: null;
        }; 

        foreach( $this->data['entries'] as $id => $entry )
        {
            // If assignment has aleady been saved, find the saved property meta for this entry
            $saved_property = NULL;
            if(!is_null($this->data['result']))
            {
                $saved_property = $getSavedPropertyByName($this->data['result']['entries'], $entry['name']);
            }
			
			$this->data['entries'][$id]['properties'] = array();
			
            foreach( $this->data['properties'] as $property ){
                if ( $property['entry_id'] !== $entry['id'] )
                    continue;

                if (!isset($this->data['entries'][$id]['properties']))
                    $this->data['entries'][$id]['properties'] = array();
             
                // Mark a property as selected if matched with saved property
                $property['selected'] = false;
                if(!is_null($saved_property) && $saved_property['value'] == $property['content'])
                {
                    $property['selected'] = $saved_property['value'];
                }

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
		load_sidebar( $this->data );
		
        return view('front/assignment', $this->data);
    }
}
