<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use CodeIgniter\I18n\Time;

use App\Models\Assignments;
use App\Models\AssignmentEntry;
use App\Models\AssignmentEntryProperties;

class AssignmentsController extends BaseController
{
    protected $assignments;

    public function __construct()
    {
        $this->assignments = new Assignments();
    }
		
	public function save_order()
	{
		$sort_order = $this->request->getPost('sort_order');
		
        foreach ($sort_order as $order => $id) {
           $this->assignments->update($id, ['sort_order' => $order]);
        }

        return $this->response->setJSON(['status' => 'success']);
	}
	
    public function add_assignment()
    {
		$meeting_id = $this->request->getPost('meeting_id');
		$name = $this->request->getPost('name');
		
		// find sort order 
		$existing_entries = $this->assignments->where('meeting_id', $meeting_id)->findAll();

		$max_sort_order = 0;
		if ( $existing_entries )
			$max_sort_order = max(array_column($existing_entries, 'sort_order'));
		
		// make sure new item is last
		$new_sort_order = $max_sort_order + 1;		
		
		$this->assignments->insert([
			'meeting_id' 	=> $meeting_id,
			'name'			=> $name,
			'sort_order'	=> $new_sort_order,
            'created_at'	=> Time::now()
        ]);

		$insert_id = $this->assignments->insertID();

		return $this->response->setJSON([
			'status' 		=> 'success', 
			'redirect_url'	=> base_url(route_to('admin.assignment', $insert_id)),
			'assignment_id' => $insert_id
		]);
    }
	
	public function delete_assignment()
	{
		
		$assignment_id = (int) $this->request->getPost('assignment_id');
		
		if ( empty($assignment_id) )
			return;

		$this->assignments->delete( $assignment_id );	
		// Removal of related tables happens through cascaded foreign relations
		
		return $this->response->setJSON(['status' => 'success']);
	}
}
