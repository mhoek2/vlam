<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class MeetingController extends BaseController
{
    public function __construct() {
		
    }

    public function index( $meeting_id ): string
    {
        $data = array();

        $this->header->getHeader( $data );

        // Meeting
        $data['meeting'] = $this->meetings->find( $meeting_id );
        $data["current_meeting"] = $data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		
		// Cases
        $data['cases'] = $this->cases->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();

        return view('front/meeting', $data);
    }
}
