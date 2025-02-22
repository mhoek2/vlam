<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;

use App\Models\Admin\Header;

use App\Models\Meetings;
use App\Models\Assignments;
use App\Models\Cases;
use App\Models\CaseEntry;
use App\Models\CaseEntryProperties;

use Config\CKeditor;

class CaseController extends BaseController
{
    protected $cases;

    public function __construct()
    {
        $this->header = new Header();

        $this->meetings = new Meetings();
        $this->assignments = new Assignments();

        $this->cases = new Cases();
        $this->caseEntry = new CaseEntry();
        $this->caseEntryProperties = new CaseEntryProperties();
    }

	public function save( $case_id )
	{
        $name = $this->request->getPost('name');
        $info = $this->request->getPost('info');
        $intro = $this->request->getPost('intro');
        $outro = $this->request->getPost('outro');

		$this->cases->update($case_id, [
            'name' => $name,
            'info' => $info,
            'intro' => $intro,
            'outro' => $outro
        ]);

		return $this->response->setJSON(['message' => 'Form submitted successfully!']);
	}
	
    public function index( $case_id ): string
    {
        $data = array();
        $this->header->getHeader( $data );

		$data['case'] = $this->cases->find($case_id);
		$data['entries'] = $this->caseEntry->where('case_id', $case_id)->orderBy('sort_order', 'ASC')->findAll();
		$data['entry_types'] = $this->caseEntry->type_enum;

		
		$data['assignment'] = $this->assignments->find($data['case']['assignment_id']);
		if(is_null($data['assignment'])){
			die('no assignment');
		}
		
		$data['meeting'] = $this->meetings->find($data['assignment']['meeting_id']);
		if(is_null($data['meeting'])){
			die('no assignment');
		}
		
		// Check if case exists, otherwise show an error or a message
		if (!$data['case']) {
			// Handle the case when the case is not found
			//return redirect()->to('/some-error-page')->with('error', 'Case not found.');
			echo "Case not found.";
			exit;
		}

		$data['text_editor'] = service('text_editor');
		
        return view('admin/case', $data);
    }

	//
	// ENTRY
	//
	public function add_entry( $case_id )
	{
		$new_entry_name = $this->request->getPost('entry_name');

		$existing_entries = $this->caseEntry->where('case_id', $case_id)->findAll();

		$max_sort_order = 0;
		if ($existing_entries) {
			$max_sort_order = max(array_column($existing_entries, 'sort_order'));
		}

		$new_sort_order = $max_sort_order + 1;	
		
		$this->caseEntry->insert([
			'case_id' => $case_id, 
			'name' => $new_entry_name, 
			'sort_order' => $new_sort_order ]
		);
		
		$insert_id = $this->caseEntry->insertID();

		$entry = $this->caseEntry->where('case_id', $case_id)->find( $insert_id );
		$entry['entry_types'] = $this->caseEntry->type_enum;

		return $this->response->setJSON([
			'status' => 'success', 
			'html' => view('admin/case_entry', $entry)
		]);
	}
	
	public function entries_save_order( $case_id )
	{
		$sort_order = $this->request->getPost('sort_order');

        foreach ($sort_order as $order => $id) {
			$result = $this->caseEntry->where('case_id', (int)$case_id)
                                       ->update($id, ['sort_order' => $order]);
        }

        return $this->response->setJSON(['status' => 'success']);
	}
	
	public function update_entry_name()
	{
		$entry_id = $this->request->getPost('entry_id');
		$new_entry_name = $this->request->getPost('entry_name');

		$this->caseEntry->update($entry_id, ['name' => $new_entry_name]);

		return $this->response->setJSON(['status' => 'success']);
	}
	
	public function update_entry_type()
	{
		$entry_id = $this->request->getPost('entry_id');
		$new_type = $this->request->getPost('type');

		// clear properties
		$this->clear_entry_properties($entry_id);
		
		$this->caseEntry->update($entry_id, ['type' => $new_type]);

		// add default property if required for the new type
		if ($new_type === "text_separator") {
			$this->caseEntryProperties->insert([
				'entry_id' => $entry_id,
				'content' => "",
			]);
		}	
		
		return $this->response->setJSON(['status' => 'success']);
	}

	public function delete_entry( $case_id )
	{
		$entry_id = $this->request->getPost('entry_id');

		if (empty($entry_id) || empty($case_id)) {
			return;
		}

		$this->caseEntry->where([
            'case_id' => $case_id
        ])->delete($entry_id);

		$this->caseEntryProperties->where([
            'entry_id' => $entry_id,
        ])->delete();

		return $this->response->setJSON(['status' => 'success']);
	}

	
	//
	// ENTRY PROPERTIES
	//	
	public function get_properties( $case_id, $entry_id )
	{
		$properties = $this->caseEntryProperties->where('entry_id', $entry_id)->orderBy('sort_order', 'ASC')->findAll();
		return $this->response->setJSON($properties);
	}
	
	public function add_property()
	{
		$entry_id = $this->request->getPost('entry_id');
		$property_content = $this->request->getPost('property_content');
		
		$this->caseEntryProperties->insert([
			'entry_id' => $entry_id,
			'content' => $property_content,
		]);

		return $this->response->setJSON(['status' => 'success']);
	}

	public function update_property( $case_id )
	{
		$property_id = $this->request->getPost('property_id');
		$property_content = $this->request->getPost('property_content');

		$this->caseEntryProperties->update($property_id, ['content' => $property_content]);

		return $this->response->setJSON(['status' => 'success']);
	}
	
	public function delete_property( $case_id, $property_id )
	{
		$this->caseEntryProperties->delete($property_id);

		return $this->response->setJSON(['status' => 'success']);
	}
	
	public function clear_entry_properties( $entry_id )
	{
		$this->caseEntryProperties->where('entry_id', $entry_id)->delete();
		
		return $this->response->setJSON(['status' => 'success']);
	}
	
	public function properties_save_order( $case_id )
	{
		$sort_order = $this->request->getPost('sort_order');
		$entry_id = (int)$this->request->getPost('entry_id');

        foreach ($sort_order as $order => $id) {
			$result = $this->caseEntryProperties->where('entry_id', $entry_id)
                                       ->update($id, ['sort_order' => $order]);
        }
		
		return $this->response->setJSON(['status' => 'success']);
	}
}
