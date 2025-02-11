<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

use App\Models\Header;
use App\Models\User;
use App\Models\Meetings;
use App\Models\Assignments;
use App\Models\AssignmentEntry;
use App\Models\AssignmentEntryProperties;

class AssignmentController extends BaseController
{
    public function __construct() {
        $this->header = new Header();
        $this->user = new User();

        $this->meetings = new Meetings();

        $this->assignments = new Assignments();
        $this->assignmentEntry = new assignmentEntry();
        $this->assignmentEntryProperties = new AssignmentEntryProperties();
    }

    private static function find_properties( $entry_id, &$data )
    {

    }

    public function index( $meeting_id, $assignment_id ): string
    {
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

        foreach( $data['entries'] as $id => $entry )
        {
            //$this->find_properties( $entry['id'], $data['entries'][$id] );
            foreach( $data['properties'] as $property ){
                if ( $property['entry_id'] !== $entry['id'] )
                    continue;

                if (!isset($data['entries'][$id]['properties']))
                    $data['entries'][$id]['properties'] = array();

                array_push( $data['entries'][$id]['properties'], $property );
            }
        }


        //print_r($data['properties']);

		if (!$data['assignment']) {
			// Handle the case when the assignment is not found
			//return redirect()->to('/some-error-page')->with('error', 'Assignment not found.');
			echo "Assignment not found.";
			exit;
		}

        return view('front/assignment', $data);
    }
}
