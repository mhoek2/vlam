<?php

namespace App\Controllers\Front\SubAssignments;

use App\Controllers\Front\BaseController;


class OutroController extends BaseController
{
	public function get_assignment( $assignment_id )
	{
		$assignment = $this->assignments->find($assignment_id);
		
		if ( is_null($assignment) ){
			die("Assignment not found.");
		}
		
		return $assignment;
	}

    public function index( $meeting_id, $assignment_id ): string
    {
		$meeting_id 	= (int) $meeting_id;
		$assignment_id 	= (int) $assignment_id;
	
        // Meeting
        $this->data['meeting'] = $this->meetings->find( $meeting_id );
        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		$this->data['assignment'] = $this->get_assignment( $assignment_id );
		
        // Cases
        $this->data['cases'] = $this->cases->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();

		// previous and next urls
		$this->data['prev_url'] = base_url(route_to('front.meeting', $this->data['meeting']['id']));
		
		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
        return view('front/sub_assignments/outro', $this->data);
    }
}
