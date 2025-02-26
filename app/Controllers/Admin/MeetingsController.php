<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;

use App\Models\Meetings;

class MeetingsController extends BaseController
{
    public function __construct() {
        $this->meetings = new Meetings();
    }

    public function index(): string
    {
		// Meeting
        $this->data['meetings'] = $this->meetings->findAll();

		load_header( $this->data );
		load_footer( $this->data );
		
        return view('admin/meetings', $this->data);
    }
}