<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\Admin\Header;

use App\Models\Meetings;
use App\Models\Assignments;

class MeetingController extends BaseController
{
    public function __construct() {
        $this->header = new Header();
        $this->meetings = new Meetings();
        $this->assignments = new Assignments();
    }

    public function save( $meeting_id )
    {
        // Check if user is logged in by verifying session data
       // if ( !$this->user->isAdmin() ) {
        //    return $this->response->setJSON(['message' => 'You must be an admin to submit this form.']);
        //}

        $meeting_info = $this->request->getPost('info');
        $meeting_intro = $this->request->getPost('intro');

		$this->meetings->update($meeting_id, [
            'info' => $meeting_info,
            'intro' => $meeting_intro
        ]);

        return $this->response->setJSON(['message' => 'Form submitted successfully!']);
    }

    public function index( $meeting_id ): string
    {
        $data = array();
        $this->header->getHeader( $data );

        $data['meeting'] = $this->meetings->find( $meeting_id );
        $data["current_meeting"] = $data["meeting"] != false ? $meeting_id : false;


        $data['assignments'] = $this->assignments->orderBy('sort_order', 'ASC')->findAll();
        $data['assignments_view'] = view('admin/assignments', $data);

        return view('admin/meeting', $data);
    }
}