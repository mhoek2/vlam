<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use CodeIgniter\I18n\Time;

use App\Models\Cases;
use App\Models\CaseEntry;
use App\Models\CaseEntryProperties;

class CasesController extends BaseController
{
    protected $cases;

    public function __construct()
    {
        $this->cases = new Cases();
    }
		
	public function save_order()
	{
		$sort_order = $this->request->getPost('sort_order');
		
        foreach ($sort_order as $order => $id) {
           $this->cases->update($id, ['sort_order' => $order]);
        }

        return $this->response->setJSON(['status' => 'success']);
	}
	
    public function add_case()
    {
		$assignment_id = $this->request->getPost('assignment_id');
		$name = $this->request->getPost('name');
		
		// find sort order 
		$existing_entries = $this->cases->where('assignment_id', $assignment_id)->findAll();

		$max_sort_order = 0;
		if ($existing_entries) {
			$max_sort_order = max(array_column($existing_entries, 'sort_order'));
		}
		
		// make sure new item is last
		$new_sort_order = $max_sort_order + 1;		
		
		$this->cases->insert([
			'assignment_id' 	=> $assignment_id,
			'name'				=> $name,
			'sort_order'		=> $new_sort_order,
            'created_at'		=> Time::now()
        ]);

		$insert_id = $this->cases->insertID();

		return $this->response->setJSON([
			'status' => 'success', 
			'case_id' => $insert_id
		]);
    }
	
	public function delete_case()
	{
		$case_id = (int) $this->request->getPost('case_id');
		
		if ( empty($case_id)) {
			return;
		}

		$this->cases->delete( $case_id );	
		// Removal of related tables happens through cascaded foreign relations

		return $this->response->setJSON(['status' => 'success']);
	}
}
