<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\Admin\Header;

use App\Models\Meetings;

class Home extends BaseController
{
    public function __construct() {
        $this->header = new Header();
    }

    public function dashboard(): string
    {
        $data = array();
        $this->header->getHeader( $data );

        return view('admin/dashboard', $data);
    }
}
