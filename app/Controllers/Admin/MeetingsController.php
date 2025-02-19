<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;

use App\Models\Admin\Header;

use App\Models\Meetings;

class MeetingsController extends BaseController
{
    public function __construct() {
        $this->header = new Header();
        $this->meetings = new Meetings();
    }

    public function index(): string
    {
        $data = array();
        $this->header->getHeader( $data );

        $data['meetings'] = $this->meetings->findAll();

        return view('admin/meetings', $data);
    }
}