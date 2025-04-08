<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;

use App\Models\Meetings;
use App\Models\Assignments;

use Config\CKeditor;

class MeetingController extends BaseController
{
	protected $meetings;	
	protected $assignments;	

    public function __construct() {
        $this->meetings = new Meetings();
        $this->assignments = new Assignments();
    }

    public function save( $meeting_id )
    {
        $meeting_info = $this->request->getPost('info');
        $meeting_intro = $this->request->getPost('intro');

		$this->meetings->update($meeting_id, [
            'info' => $meeting_info,
            'intro' => $meeting_intro
        ]);

        return $this->response->setJSON([
			'message' 			=> 'Form submitted successfully!',
			'new_csrf_token'	=> csrf_hash(),
		]);
    }

    public function index( $meeting_id ): string
    {
		// Meeting
        $this->data['meeting'] = $this->meetings->find( $meeting_id );
        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

		// Assignment
        //$this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
        $this->data['assignments'] = $this->assignments->getDetailed( $meeting_id );
        $this->data['assignments_view'] = view('admin/assignments', $this->data);

		$this->data['text_editor'] = service('text_editor');

		load_header( $this->data );
		load_footer( $this->data );
		
        return view('admin/meeting', $this->data);
    }
}