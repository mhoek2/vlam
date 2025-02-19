<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

use App\Models\Header;
use App\Models\User;
use App\Models\Meetings;
use App\Models\Assignments;
use App\Models\Cases;

class MeetingController extends BaseController
{
    public function __construct() {
        $this->header = new Header();
        $this->user = new User();
        $this->meetings = new Meetings();
        $this->assignments = new Assignments();
        $this->cases = new Cases();
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
