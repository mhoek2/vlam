<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class Home extends BaseController
{
    public function __construct() {

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
        $data['meetings'] = $this->meetings->findAll();
        $data["current_meeting"] = false;

        return view('front/dashboard', $data);
    }
}
