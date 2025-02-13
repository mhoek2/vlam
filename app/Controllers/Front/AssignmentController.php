<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

use App\Models\Header;
use App\Models\User;
use App\Models\Meetings;
use App\Models\Assignments;
use App\Models\AssignmentEntry;
use App\Models\AssignmentEntryProperties;

use App\Models\AssignmentResult;
use App\Models\AssignmentResultEntry;

class AssignmentController extends BaseController
{
    public function __construct() {
        $this->header = new Header();
        $this->user = new User();

        $this->meetings = new Meetings();

        $this->assignments = new Assignments();
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
        $user = $this->user->getUserInfo();

        $data = array();

        $this->header->getHeader( $data );

        // Meeting
        $data['meeting'] = $this->meetings->find( $meeting_id );
        $data["current_meeting"] = $data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		$data['assignment'] = $this->assignments->find($assignment_id);

        // Entries
        $data['entries'] = $this->assignmentEntry->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();
		$data['entry_types'] = $this->assignmentEntry->type_enum;

        // Entry properties
		$data['properties'] = $this->assignmentEntryProperties->orderBy('sort_order', 'ASC')->findAll();

        // Saved results
        $data['result'] = $this->assignmentResult->where([
            'user_id' => $user['id'],
            'name' => $data['assignment']['name']
        ])->first();
        if(!is_null($data['result']))
        {
            $data['result']['entries'] = $this->assignmentResultEntry->where('result_id', $data['result']['id'])->findAll();
        }

        $getSavedPropertyByName = function($entries, $name) {
            // Use array_filter to find the entry with the matching id
            $filteredEntries = array_filter($entries, function($entry) use ($name) {
                return $entry['name'] === $name;
            });

            // Return the first match or null if no match is found
            return reset($filteredEntries) ?: null;
        }; 

        foreach( $data['entries'] as $id => $entry )
        {
            // If assignment has aleady been saved, find the saved property meta for this entry
            $saved_property = NULL;
            if(!is_null($data['result']))
            {
                $saved_property = $getSavedPropertyByName($data['result']['entries'], $entry['name']);
            }

            foreach( $data['properties'] as $property ){
                if ( $property['entry_id'] !== $entry['id'] )
                    continue;

                if (!isset($data['entries'][$id]['properties']))
                    $data['entries'][$id]['properties'] = array();
             
                // Mark a property as selected if matched with saved property
                $property['selected'] = false;
                if(!is_null($saved_property) && $saved_property['value'] == $property['content'])
                {
                    $property['selected'] = $saved_property['value'];
                }

                array_push( $data['entries'][$id]['properties'], $property );
            }
        }

		if (!$data['assignment']) {
			// Handle the case when the assignment is not found
			//return redirect()->to('/some-error-page')->with('error', 'Assignment not found.');
			echo "Assignment not found.";
			exit;
		}

        return view('front/assignment', $data);
    }
}
