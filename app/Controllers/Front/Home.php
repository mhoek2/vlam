<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class Home extends BaseController
{
    public function index(): string
    {
		load_header( $this->data );
		load_footer( $this->data );
		
        return view('front/landing', $this->data);
    }

    public function application(): string
    {
        // Meetings
        $this->data['meetings'] = $this->meetings->findAll();
		
		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
        return view('front/dashboard', $this->data);
    }
}
