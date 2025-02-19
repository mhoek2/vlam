<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class Home extends BaseController
{
    public function __construct() {

    }

    public function index(): string
    {
        return view('front/welcome_message', $this->data);
    }

    public function application(): string
    {
        // Meetings
        $this->data['meetings'] = $this->meetings->findAll();
        $this->data["current_meeting"] = false;
		
		load_header( $this->data );
		load_sidebar( $this->data );
		
        return view('front/dashboard', $this->data);
    }
}
