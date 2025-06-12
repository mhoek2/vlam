<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;

use App\Models\Meetings;
use App\Models\Assignments;
use App\Models\AssignmentEntry;
use App\Models\AssignmentEntryProperties;

use App\Models\Cases;

use Config\CKeditor;

class AssignmentController extends BaseController
{
	protected $meetings;	
	
	protected $assignments;
	protected $assignmentEntry;	
	protected $assignmentEntryProperties;
	
	protected $cases;	
	
    public function __construct()
    {
        $this->meetings = new Meetings();

        $this->assignments = new Assignments();
        $this->assignmentEntry = new assignmentEntry();
        $this->assignmentEntryProperties = new AssignmentEntryProperties();
		
		$this->cases = new Cases();
    }
	
	private function extractYouTubeID( $url ) {
		$pattern = '/(?:youtube\.com\/.*v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/';

		if ( preg_match( $pattern, $url, $matches ) )
			return $matches[1];

		return null;
	}

	public function save( $assignment_id )
	{
        $name = $this->request->getPost('name');
        $info = $this->request->getPost('info');
        $intro = $this->request->getPost('intro');
        $outro = $this->request->getPost('outro');
        $sub_assignment = $this->request->getPost('sub_assignment');

		$this->assignments->update($assignment_id, [
            'name' 				=> $name,
            'info' 				=> $info,
            'intro' 			=> $intro,
            'outro' 			=> $outro,
            'sub_assignment' 	=> $sub_assignment
        ]);

		return $this->response->setJSON([
			'message' 			=> 'Form submitted successfully!',
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
	private function get_sub_assignments( $assignment )
	{
		$controllers = [[
			"name" 		=> "default",
			"selected"	=> is_null($assignment["sub_assignment"])
		]];
		
		$dir = APPPATH . 'Controllers/Front/SubAssignments';
		foreach (glob($dir . '/*Controller.php') as $file) {
			$name = basename($file, '.php');
			array_push($controllers, [
				"name" 		=> $name,
				"selected"	=> $assignment["sub_assignment"] === $name
			]);
		}
		
		return $controllers;
	}
	
    public function index( $assignment_id ): string
    {
		// Assignment
		$this->data['assignment'] = $this->assignments->find($assignment_id);

		if (!$this->data['assignment'])
			die("Assignment invalid.");
		
		// Meeting
		$this->data['meeting'] = $this->meetings->find($this->data['assignment']['meeting_id']);
		if(is_null($this->data['meeting']))
			die("Meeting invalid");
		
		// Entry
		$this->data['entries'] = $this->assignmentEntry->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();

		// Entry types
		$this->data['entry_types'] = $this->assignmentEntry->type_enum;
		$this->data['entry_type_to_group'] = $this->assignmentEntry->type_to_group;
		
		foreach( $this->data['entries'] as $id => &$entry )
		{
			// should never happen, make sure entry is valid!
			// this is a fail-safe, assignmentEntry Model has query overrides.
			if (!$this->assignmentEntry->valid_type($entry['type'])) {
				unset($this->data['entries'][$id]);
				continue;
			}
			
			$type = $this->assignmentEntry->get_type($entry['type']);
			$entry['type_short'] = !is_null($type) ? $type['short'] : "n/a";
			
			$entry['type_group'] = $this->assignmentEntry->find_group($entry['type']);
			
			$entry['is_multi_type_group'] = !is_null($entry['type_group']) && ($this->assignmentEntry->group_counts[$entry['type_group']] > 1);
			$entry['is_input'] = $this->assignmentEntry->user_input_type($entry['type']);
		}
		
		// Case
        //$this->data['cases'] = $this->cases->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();	
        $this->data['cases'] = $this->cases->getDetailed( $assignment_id );	
        $this->data['cases_view'] = view('admin/cases', $this->data);		
		
		$this->data['text_editor'] = service('text_editor');
		
		$this->data['sub_assignments'] = $this->get_sub_assignments( $this->data['assignment'] );
		
		load_header( $this->data );
		load_footer( $this->data );
		
        return view('admin/assignment', $this->data);
    }

	//
	// ENTRY
	//
	public function add_entry( $assignment_id )
	{
		$new_entry_name = $this->request->getPost('entry_name');
		$new_entry_type = $this->request->getPost('entry_type');

		$entries = $this->assignmentEntry->where('assignment_id', $assignment_id)->findAll();

		$this->assignmentEntry->insert([
			'assignment_id'	=> $assignment_id, 
			'name' 			=> $new_entry_name, 
			'type' 			=> $new_entry_type,
			'sort_order' 	=> $entries ? max(array_column($entries, 'sort_order')) + 1 : 0,
		]);
		
		$insert_id = $this->assignmentEntry->insertID();

		$entry = $this->assignmentEntry->where('assignment_id', $assignment_id)->find( $insert_id );
		
		if ( is_null( $entry ) ) {
			return $this->response->setJSON([
				'status' 			=> 'error', 
				'new_csrf_token'	=> csrf_hash(),
			]);
		}
		
		$entry['entry_types'] = $this->assignmentEntry->type_enum;	
		
		$type = $this->assignmentEntry->get_type($entry['type']);
		$entry['type_short'] = !is_null($type) ? $type['short'] : "n/a";

		$entry['type_group'] = $this->assignmentEntry->find_group($entry['type']);
		$entry['is_multi_type_group'] = !is_null($entry['type_group']) && ($this->assignmentEntry->group_counts[$entry['type_group']] > 1);
		$entry['is_input'] = $this->assignmentEntry->user_input_type($entry['type']);
		
		// add default property if required for the new type
		if ($new_entry_type === "text_separator") {
			$this->assignmentEntryProperties->insert([
				'entry_id' 	=> $insert_id,
				'content' 	=> "",
			]);
		}
		
		if ($new_entry_type === "video_youtube") {
			$has_video_id = $this->extractYouTubeID( $new_entry_name );
			
			$this->assignmentEntryProperties->insert([
				'entry_id' 	=> $insert_id,
				'content' 	=> $has_video_id ? $has_video_id : "",
			]);
		}	
		
		return $this->response->setJSON([
			'status' 			=> 'success', 
			'html' 				=> view('admin/assignment_entry', $entry),
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
	public function entries_save_order( $assignment_id )
	{
		$sort_order = $this->request->getPost('sort_order');

        foreach ($sort_order as $order => $id) {
			$result = $this->assignmentEntry->where('assignment_id', (int)$assignment_id)
                                       ->update($id, ['sort_order' => $order]);
        }

        return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
	public function update_entry_name()
	{
		$entry_id = $this->request->getPost('entry_id');
		$new_entry_name = $this->request->getPost('entry_name');

		$this->assignmentEntry->update($entry_id, ['name' => $new_entry_name]);

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
	public function update_entry_optional()
	{
		$entry_id = $this->request->getPost('entry_id');
		$value = (int)$this->request->getPost('value');
		
		$this->assignmentEntry->update($entry_id, ['optional' => $value]);
		
		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
	public function update_entry_type()
	{
		$entry_id = $this->request->getPost('entry_id');
		$new_type = $this->request->getPost('type');

		$entry = $this->assignmentEntry->find( $entry_id );
		$type_group = $this->assignmentEntry->find_group($entry['type']);
		$new_type_group = $this->assignmentEntry->find_group($new_type);
		
		if ( $type_group !== $new_type_group )
			return $this->response->setJSON(['status' => 'error', 'message' => 'entry types do not match!']);
		
		// clear properties
		// deprecated (03/03/2025) - type groups are implemented.
		// can not change to non-matching types, type has to be chosen on 'add_entry'.
		//$this->clear_entry_properties($entry_id);
		
		$this->assignmentEntry->update($entry_id, ['type' => $new_type]);

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}

	public function delete_entry( $assignment_id )
	{
		$entry_id = $this->request->getPost('entry_id');

		if (empty($entry_id) || empty($assignment_id)) {
			return;
		}

		$this->assignmentEntry->where([
            'assignment_id' => $assignment_id
        ])->delete($entry_id);
		// Removal of related tables happens through cascaded foreign relations
		
		return $this->response->setJSON([
			'status' => 'success',
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}

	
	//
	// ENTRY PROPERTIES
	//	
	public function get_properties( $assignment_id, $entry_id )
	{
		$properties = $this->assignmentEntryProperties->where('entry_id', $entry_id)->orderBy('sort_order', 'ASC')->findAll();
		return $this->response->setJSON($properties);
	}
	
	public function add_property()
	{
		$entry_id = $this->request->getPost('entry_id');
		$property_content = $this->request->getPost('property_content');
		
		$properties = $this->assignmentEntryProperties->where('entry_id', $entry_id)->findAll();

		$this->assignmentEntryProperties->insert([
			'entry_id' 		=> $entry_id,
			'content' 		=> $property_content,
			'sort_order'	=> $properties ? max(array_column($properties, 'sort_order')) + 1 : 0,
		]);

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}

	public function update_property( $assignment_id )
	{
		$property_id = $this->request->getPost('property_id');
		$property_content = $this->request->getPost('property_content');

		$this->assignmentEntryProperties->update($property_id, ['content' => $property_content]);

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
	public function delete_property( $assignment_id, $property_id )
	{
		$this->assignmentEntryProperties->delete($property_id);

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
	public function clear_entry_properties( $entry_id )
	{
		$this->assignmentEntryProperties->where('entry_id', $entry_id)->delete();
		
		return $this->response->setJSON(['status' => 'success']);
	}
	
	public function properties_save_order( $assignment_id )
	{
		$sort_order = $this->request->getPost('sort_order');
		$entry_id = (int)$this->request->getPost('entry_id');

        foreach ($sort_order as $order => $id) {
			$result = $this->assignmentEntryProperties->where('entry_id', $entry_id)
                                       ->update($id, ['sort_order' => $order]);
        }

		return $this->response->setJSON([
			'status' 			=> 'success',
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
}
