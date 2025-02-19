<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

use App\Models\CaseEntry;
use App\Models\CaseEntryProperties;

class CaseController extends BaseController
{
    public function __construct() {
        $this->caseEntry = new CaseEntry();
        $this->caseEntryProperties = new CaseEntryProperties();	
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

		
        // Cases
        $data['cases'] = $this->cases->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		$data['case'] = $this->cases->find($assignment_id);

        // Entries
        $data['entries'] = $this->caseEntry->where('case_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();
		$data['entry_types'] = $this->caseEntry->type_enum;

        // Entry properties
		$data['properties'] = $this->caseEntryProperties->orderBy('sort_order', 'ASC')->findAll();

        // Saved results
		$data['result'] = NULL;
        /*$data['result'] = $this->assignmentResult->where([
            'user_id' => $user['id'],
            'name' => $data['case']['name']
        ])->first();
        if(!is_null($data['result']))
        {
            $data['result']['entries'] = $this->assignmentResultEntry->where('result_id', $data['result']['id'])->findAll();
        }*/

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

		if (!$data['case']) {
			// Handle the case when the assignment is not found
			//return redirect()->to('/some-error-page')->with('error', 'Assignment not found.');
			echo "Assignment not found.";
			exit;
		}

        return view('front/case', $data);
    }
}
