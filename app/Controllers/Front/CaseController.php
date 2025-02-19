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
	
	public function entry( $meeting_id, $case_id, $entry_num )
	{		
        // Meeting
        $this->data['meeting'] = $this->meetings->find( $meeting_id );
        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
	
        // Cases
        $this->data['cases'] = $this->cases->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		
        // Entries
		$this->data['entries'] = $this->caseEntry->where('case_id', $case_id)->orderBy('sort_order', 'ASC')->findAll();	// to draw progressbar
		
        $this->data['entry'] = $this->caseEntry->where([
			'case_id'		=> $case_id,
			'sort_order'	=> $entry_num
		])->first();
		$this->data['entry_types'] = $this->caseEntry->type_enum;
		
		
		
		
		// Entry properties
		$this->data['properties'] = $this->caseEntryProperties->where('entry_id', $this->data['entry']['id'])->orderBy('sort_order', 'ASC')->findAll();

        // Saved results
		$this->data['result'] = NULL;
        /*$this->data['result'] = $this->assignmentResult->where([
            'user_id' => $this->data['user']['id'],
            'name' => $this->data['case']['name']
        ])->first();
        if(!is_null($this->data['result']))
        {
            $this->data['result']['entries'] = $this->assignmentResultEntry->where('result_id', $this->data['result']['id'])->findAll();
        }*/

        $getSavedPropertyByName = function($entries, $name) {
            // Use array_filter to find the entry with the matching id
            $filteredEntries = array_filter($entries, function($entry) use ($name) {
                return $entry['name'] === $name;
            });

            // Return the first match or null if no match is found
            return reset($filteredEntries) ?: null;
        }; 

		// If assignment has aleady been saved, find the saved property meta for this entry
		$saved_property = NULL;
		if(!is_null($this->data['result']))
		 {
		    $saved_property = $getSavedPropertyByName($this->data['result']['entries'], $entry['name']);
		}

		$this->data['entry']['properties'] = array();
		
		foreach( $this->data['properties'] as $property ){
			if ( $property['entry_id'] !== $this->data['entry']['id'] )
				continue;

			if (!isset($this->data['entry']['properties']))
				$this->data['entry']['properties'] = array();

			// Mark a property as selected if matched with saved property
			$property['selected'] = false;

			if(!is_null($saved_property) && $saved_property['value'] == $property['content'])
			{
				$property['selected'] = $saved_property['value'];
			}

			array_push( $this->data['entry']['properties'], $property );
		}
	
		

		
		
		
		
		
		
		load_header( $this->data );
		load_sidebar( $this->data );
		
        return view('front/case_entry', $this->data);		
	}

    public function index( $meeting_id, $case_id ): string
    {
        // Meeting
        $this->data['meeting'] = $this->meetings->find( $meeting_id );
        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
	
        // Cases
        $this->data['cases'] = $this->cases->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		$this->data['case'] = $this->cases->find($case_id);

        // Entries
        $this->data['entries'] = $this->caseEntry->where('case_id', $case_id)->orderBy('sort_order', 'ASC')->findAll();

		if (!$this->data['case']) {
			// Handle the case when the assignment is not found
			//return redirect()->to('/some-error-page')->with('error', 'Assignment not found.');
			echo "Assignment not found.";
			exit;
		}

		load_header( $this->data );
		load_sidebar( $this->data );
		
        return view('front/case', $this->data);
    }
}
