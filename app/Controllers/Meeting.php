<?php

namespace App\Controllers;

use App\Models\Header;
use App\Models\User;
use App\Models\Meetings;

class Meeting extends BaseController
{
    public function __construct() {
        $this->header = new Header();
        $this->user = new User();
        $this->meetings = new Meetings();
    }

    public function index( $id ): string
    {
        $data = array();

        $this->header->getHeader( $data );

        // Meetings
        $data["meetings"] = $this->meetings->get_all_meetings();
        $data["meeting"] = $this->meetings->get_meeting($id);
        $data["current_meeting"] = $data["meeting"] != false ? $id : false;

        return view('meeting', $data);
    }
}
