<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class MeetingController extends BaseController
{
    public function __construct() {
		
    }

    public function index( $meeting_id ): string
    {
		// Meeting
        $this->data['meeting'] = $this->meetings->find( $meeting_id );
        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		
		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
        return view('front/meeting', $this->data);
    }
}
