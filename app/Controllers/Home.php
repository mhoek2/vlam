<?php

namespace App\Controllers;

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


        return view('welcome_message', $data);
    }

    public function application(): string
    {
        $data = array();
        $this->header->getHeader( $data );

        // Meetings
        $data["meetings"] = $this->meetings->get_all_meetings();
        $data["current_meeting"] = false;

        return view('dashboard', $data);
    }
}
