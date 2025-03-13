<?php

namespace App\Controllers\Front\SubAssignments;

use App\Controllers\Front\BaseController;


class PodcastController extends BaseController
{
    public function index( $meeting_id, $assignment_id ): string
    {
		// Post-save logic for storing custom data via service('user_meta') after case/assignment completion.
		// Custom logic may be required to store additional user-specific information in certain scenarios.
		//
		// example:
		// $user_meta = service('user_meta');
		// $user_meta->save( 'key', 'value', /*(Optional) user_id*/ );
		// $record = $user_meta->find( 'key', /*(Optional) user_id*/ );
		
		// Additionaly, For assignments only:
		// This can fully override an assignment if no entries exist. 
		// If selected, the Controller & View will be displayed directly, enabling a completely custom assignment.
		
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
		
        return view('front/sub_assignments/podcast', $this->data);
    }
}
