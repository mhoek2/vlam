<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

use App\Models\Header;
use App\Models\Meetings;

class Home extends BaseController
{
    public function __construct() {
        $this->header = new Header();
        $this->meetings = new Meetings();
    }

    public function index(): string
    {
        $data = array();
        $this->header->getHeader( $data );


        return view('front/welcome_message', $data);
    }

    public function application(): string
    {
        $data = array();
        $this->header->getHeader( $data );

        // Meetings
        $data["meetings"] = $this->meetings->get_all_meetings();
        $data["current_meeting"] = false;

        return view('front/dashboard', $data);
    }
}
