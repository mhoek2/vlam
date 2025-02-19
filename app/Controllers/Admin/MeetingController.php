<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\Admin\Header;

use App\Models\Meetings;
use App\Models\Assignments;
use App\Models\Cases;

use Config\CKeditor;

class MeetingController extends BaseController
{
    public function __construct() {
        $this->header = new Header();
        $this->meetings = new Meetings();
        $this->assignments = new Assignments();
        $this->cases = new Cases();
    }

    public function save( $meeting_id )
    {
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


        $data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
        $data['assignments_view'] = view('admin/assignments', $data);

	    $data['cases'] = $this->cases->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
        $data['cases_view'] = view('admin/cases', $data);	
		
        $data['CKeditorApiKey'] = (new CKeditor())->apiKey;

        return view('admin/meeting', $data);
    }
}