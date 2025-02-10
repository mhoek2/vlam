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

    public function save( $id )
    {
        // Check if user is logged in by verifying session data
        if ( !$this->user->isAdmin() ) {
            return $this->response->setJSON(['message' => 'You must be an admin to submit this form.']);
        }

        $data = [
            "info" => $this->request->getPost('info'),
            "intro" => $this->request->getPost('intro'),
        ];

        if ( $this->meetings->set_meeting( $id, $data ) )
        {
            return $this->response->setJSON(['message' => 'Form submitted successfully!']);
        }

        return $this->response->setJSON(['message' => 'An unrecoverable issue is raised!']);
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
