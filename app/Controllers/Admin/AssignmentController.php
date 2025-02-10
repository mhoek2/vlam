<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\Admin\Header;

use App\Models\Meetings;
use App\Models\Assignments;
use App\Models\AssignmentEntry;
use App\Models\AssignmentEntryProperties;

class AssignmentController extends BaseController
{
    protected $assignments;

    public function __construct()
    {
        $this->header = new Header();

        $this->meetings = new Meetings();

        $this->assignments = new Assignments();
        $this->assignmentEntry = new assignmentEntry();
        $this->assignmentEntryProperties = new AssignmentEntryProperties();
    }
	
    public function index( $assignment_id ): string
    {
        $data = array();
        $this->header->getHeader( $data );

		$data['assignment'] = $this->assignments->find($assignment_id);
		$data['entries'] = $this->assignmentEntry->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();
		$data['entry_types'] = $this->assignmentEntry->type_enum;

		$data['meeting'] = $this->meetings->find($data['assignment']['meeting_id']);

		// Check if assignment exists, otherwise show an error or a message
		if (!$data['assignment']) {
			// Handle the case when the assignment is not found
			//return redirect()->to('/some-error-page')->with('error', 'Assignment not found.');
			echo "Assignment not found.";
			exit;
		}
		
        return view('admin/assignment', $data);
    }
	

	//
	// ENTRY
	//

	public function add_entry( $assignment_id )
	{
		$new_entry_name = $this->request->getPost('entry_name');

		$existing_entries = $this->assignmentEntry->where('assignment_id', $assignment_id)->findAll();

		$max_sort_order = 0;
		if ($existing_entries) {
			$max_sort_order = max(array_column($existing_entries, 'sort_order'));
		}

		$new_sort_order = $max_sort_order + 1;	
		
		$this->assignmentEntry->insert([
			'assignment_id' => $assignment_id, 
			'name' => $new_entry_name, 
			'sort_order' => $new_sort_order ]
		);
		
		$insert_id = $this->assignmentEntry->insertID();
		
		return $this->response->setJSON(['status' => 'success', 'insert_id' => $insert_id]);
	}
	
	public function entries_save_order( $assignment_id )
	{
		$sort_order = $this->request->getPost('sort_order');

        foreach ($sort_order as $order => $id) {
			$result = $this->assignmentEntry->where('assignment_id', (int)$assignment_id)
                                       ->update($id, ['sort_order' => $order]);
        }

        return $this->response->setJSON(['status' => 'success']);
	}
	
	public function update_entry_name()
	{
		$entry_id = $this->request->getPost('entry_id');
		$new_entry_name = $this->request->getPost('entry_name');

		$this->assignmentEntry->update($entry_id, ['name' => $new_entry_name]);

		return $this->response->setJSON(['status' => 'success']);
	}
	
	public function update_entry_type()
	{
		$entry_id = $this->request->getPost('entry_id');
		$new_type = $this->request->getPost('type');

		// clear properties
		$this->clear_entry_properties($entry_id);
		
		$this->assignmentEntry->update($entry_id, ['type' => $new_type]);

		// add default property if required for the new type
		if ($new_type === "text_separator") {
			$this->assignmentEntryProperties->insert([
				'entry_id' => $entry_id,
				'content' => "",
			]);
		}	
		
		return $this->response->setJSON(['status' => 'success']);
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
		
		$this->assignmentEntryProperties->insert([
			'entry_id' => $entry_id,
			'content' => $property_content,
		]);

		return $this->response->setJSON(['status' => 'success']);
	}

	public function update_property( $assignment_id )
	{
		$property_id = $this->request->getPost('property_id');
		$property_content = $this->request->getPost('property_content');

		$this->assignmentEntryProperties->update($property_id, ['content' => $property_content]);

		return $this->response->setJSON(['status' => 'success']);
	}
	
	public function delete_property( $assignment_id, $property_id )
	{
		$this->assignmentEntryProperties->delete($property_id);

		return $this->response->setJSON(['status' => 'success']);
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
		
		return $this->response->setJSON(['status' => 'success']);
	}
}
