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
		$meeting_id = $this->request->getPost('meeting_id');
		$name = $this->request->getPost('name');
		
		// find sort order 
		$existing_entries = $this->cases->where('meeting_id', $meeting_id)->findAll();

		$max_sort_order = 0;
		if ($existing_entries) {
			$max_sort_order = max(array_column($existing_entries, 'sort_order'));
		}
		
		// make sure new item is last
		$new_sort_order = $max_sort_order + 1;		
		
		$this->cases->insert([
			'meeting_id' 	=> $meeting_id,
			'name'			=> $name,
			'sort_order'	=> $new_sort_order,
            'created_at'	=> Time::now()
        ]);

		$insert_id = $this->cases->insertID();

		return $this->response->setJSON([
			'status' => 'success', 
			'case_id' => $insert_id
		]);
    }
	
	public function delete_case()
	{
		$case_id = $this->request->getPost('case_id');
		
		if ( empty($case_id)) {
			return;
		}

	    $casesEntry = new CaseEntry();
        $casesEntryProperties = new CaseEntryProperties();
		
		$entries = $casesEntry->where('case_id', $case_id)->findAll();
		foreach ( $entries as $entry )
		{
			$casesEntry->where([
				'case_id' => $case_id,
			])->delete($entry['id']);
				
			$casesEntryProperties->where([
				'entry_id' => $entry['id'],
			])->delete();	
		}

		$this->cases->delete( $case_id );	
		
		return $this->response->setJSON(['status' => 'success']);
	}
}
