<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;

use App\Models\Meetings;
use App\Models\Assignments;
use App\Models\Cases;
use App\Models\CaseEntry;
use App\Models\CaseEntryProperties;

use Config\CKeditor;

class CaseController extends BaseController
{
	protected $meetings;	
	protected $assignments;	
	
	protected $cases;
	protected $caseEntry;	
	protected $caseEntryProperties;	
	
    public function __construct()
    {
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
        $complete_action = $this->request->getPost('complete_action');

		$this->cases->update($case_id, [
            'name' 				=> $name,
            'info' 				=> $info,
            'intro' 			=> $intro,
            'outro' 			=> $outro,
            'complete_action' 	=> $complete_action
        ]);

		return $this->response->setJSON([
			'message' 			=> 'Form submitted successfully!',
			'new_csrf_token'	=> csrf_hash(),
		]);
	}
	
	private function get_complete_actions( $case )
	{
		$controllers = [[
			"name" 		=> "default",
			"selected"	=> is_null($case["complete_action"])
		]];
		
		$dir = APPPATH . 'Controllers/Front/CompleteCaseActions';
		foreach (glob($dir . '/*Controller.php') as $file) {
			$name = basename($file, '.php');
			array_push($controllers, [
				"name" 		=> $name,
				"selected"	=> $case["complete_action"] === $name
			]);
		}
		
		return $controllers;
	}	
	
    public function index( $case_id ): string
    {
		// Case
		$this->data['case'] = $this->cases->find($case_id);
		if (!$this->data['case'])
			die("Case invalid.");
		
		// Assignment
		$this->data['assignment'] = $this->assignments->find($this->data['case']['assignment_id']);
		if (!$this->data['assignment'])
			die("Assignment invalid.");
		
		// Meeting
		$this->data['meeting'] = $this->meetings->find($this->data['assignment']['meeting_id']);
		if(is_null($this->data['meeting']))
			die("Meeting invalid");

		// Entry
		$this->data['entries'] = $this->caseEntry->where('case_id', $case_id)->orderBy('sort_order', 'ASC')->findAll();
		
		// Entry types
		$this->data['entry_types'] = $this->caseEntry->type_enum;
		$this->data['entry_type_to_group'] = $this->caseEntry->type_to_group;

		foreach( $this->data['entries'] as $id => &$entry )
		{
			// should never happen, make sure entry is valid!
			// this is a fail-safe, caseEntry Model has query overrides.
			if (!$this->caseEntry->valid_type($entry['type'])) {
				unset($this->data['entries'][$id]);
				continue;
			}
			
			
			$entry['type_group'] = $this->caseEntry->find_group($entry['type']);
			$entry['is_multi_type_group'] = !is_null($entry['type_group']) && ($this->caseEntry->group_counts[$entry['type_group']] > 1);
			$entry['is_input'] = $this->caseEntry->user_input_type($entry['type']);
		}

		$this->data['complete_actions'] = $this->get_complete_actions( $this->data['case'] );
		
		$this->data['text_editor'] = service('text_editor');
		
		load_header( $this->data );
		load_footer( $this->data );
		
        return view('admin/case', $this->data);
    }

	//
	// ENTRY
	//
	public function add_entry( $case_id )
	{
		$new_entry_name = $this->request->getPost('entry_name');
		$new_entry_type = $this->request->getPost('entry_type');
		
		$entries = $this->caseEntry->where('case_id', $case_id)->findAll();

		$this->caseEntry->insert([
			'case_id' 		=> $case_id, 
			'name' 			=> $new_entry_name, 
			'type' 			=> $new_entry_type,
			'sort_order'	=> $entries ? max(array_column($entries, 'sort_order')) + 1 : 0,
		]);
		
		$insert_id = $this->caseEntry->insertID();

		$entry = $this->caseEntry->where('case_id', $case_id)->find( $insert_id );
		
		if ( is_null( $entry ) ) {
			return $this->response->setJSON([
				'status' 			=> 'error', 
				'new_csrf_token'	=> csrf_hash(),
			]);
		}
			
		$entry['entry_types'] = $this->caseEntry->type_enum;
		$entry['type_group'] = $this->caseEntry->find_group($entry['type']);
		$entry['is_multi_type_group'] = !is_null($entry['type_group']) && ($this->caseEntry->group_counts[$entry['type_group']] > 1);
		$entry['is_input'] = $this->caseEntry->user_input_type($entry['type']);
		
		// add default property if required for the new type
		if ($new_entry_type === "text_separator") {
			$this->caseEntryProperties->insert([
				'entry_id' => $insert_id,
				'content' => "",
			]);
		}	
		
		return $this->response->setJSON([
			'status' 			=> 'success', 
			'html' 				=> view('admin/case_entry', $entry),
			'new_csrf_token'	=> csrf_hash(),
		]);
	}
	
	public function entries_save_order( $case_id )
	{
		$sort_order = $this->request->getPost('sort_order');

        foreach ($sort_order as $order => $id) {
			$result = $this->caseEntry->where('case_id', (int)$case_id)
                                       ->update($id, ['sort_order' => $order]);
        }

        return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token'	=> csrf_hash(),
		]);
	}
	
	public function update_entry_name()
	{
		$entry_id = $this->request->getPost('entry_id');
		$new_entry_name = $this->request->getPost('entry_name');

		$this->caseEntry->update($entry_id, ['name' => $new_entry_name]);

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token'	=> csrf_hash(),
		]);
	}
	
	public function update_entry_optional()
	{
		$entry_id = $this->request->getPost('entry_id');
		$value = (int)$this->request->getPost('value');
		
		$this->caseEntry->update($entry_id, ['optional' => $value]);
		
		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
	public function update_entry_type()
	{
		$entry_id = $this->request->getPost('entry_id');
		$new_type = $this->request->getPost('type');

		$entry = $this->caseEntry->find( $entry_id );
		$type_group = $this->caseEntry->find_group($entry['type']);
		$new_type_group = $this->caseEntry->find_group($new_type);

		if ( $type_group !== $new_type_group )
			return $this->response->setJSON(['status' => 'error', 'message' => 'entry types do not match!']);

		// clear properties
		// deprecated (03/03/2025) - type groups are implemented.
		// can not change to non-matching types, type has to be chosen on 'add_entry'.
		//$this->clear_entry_properties($entry_id);
		
		$this->caseEntry->update($entry_id, ['type' => $new_type]);

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token'	=> csrf_hash(),
		]);
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
		// Removal of related tables happens through cascaded foreign relations

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token'	=> csrf_hash(),
		]);
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
			
		$properties = $this->caseEntryProperties->where('entry_id', $entry_id)->findAll();

		$this->caseEntryProperties->insert([
			'entry_id' 		=> $entry_id,
			'content' 		=> $property_content,
			'sort_order' 	=> $properties ? max(array_column($properties, 'sort_order')) + 1 : 0,
		]);

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token'	=> csrf_hash(),
		]);
	}

	public function update_property( $case_id )
	{
		$property_id = $this->request->getPost('property_id');
		$property_content = $this->request->getPost('property_content');

		$this->caseEntryProperties->update($property_id, ['content' => $property_content]);

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token'	=> csrf_hash(),
		]);
	}
	
	public function delete_property( $case_id, $property_id )
	{
		$this->caseEntryProperties->delete($property_id);

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token'	=> csrf_hash(),
		]);
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
		
		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token'	=> csrf_hash(),
		]);
	}
}
