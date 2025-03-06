<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class MeetingController extends BaseController
{
    public function index( $meeting_id ): string
    {
		$meeting_id 	= (int) $meeting_id;

		// Meeting
        $this->data['meeting'] = $this->get_meeting( $meeting_id );
        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		
		// previous and next urls
		$this->data['prev_url'] = base_url(route_to('home'));
		
		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
        return view('front/meeting', $this->data);
    }
}
