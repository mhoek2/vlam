<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class MeetingController extends BaseController
{
    public function index( int $meeting_id ): string
    {
		// Meeting
        $this->data['meeting'] = $this->get_meeting( $meeting_id );
        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		
		// previous and next urls
		$this->data['prev_url'] = base_url(route_to('home'));
		
		$this->data['edit_url'] = $this->get_edit_route('admin.meeting', $meeting_id);
		
		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
        return view('front/meeting', $this->data);
    }
}
