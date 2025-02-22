<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;

use App\Models\Admin\Header;

use App\Models\Trainings;
use App\Models\TrainingUsers;
use App\Models\Users;

use Config\CKeditor;

class TrainingController extends BaseController
{
    public function __construct() {
        $this->header = new Header();
        $this->trainings = new Trainings();
        $this->trainingMembers = new TrainingUsers();
    }

    public function save( $training_id )
    {
        $name = $this->request->getPost('name');

		$this->trainings->update($training_id, [
            'name' => $name,
        ]);

		return $this->response->setJSON(['message' => 'Form submitted successfully!']);
    }

    public function add_member( $training_id )
    {
        $user_id = $this->request->getPost('user_id');

		$this->trainingMembers->replace([ 
			'training_id' => $training_id, 
			'user_id' => $user_id
            ]
		);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Form submitted successfully!']);
    }

    public function delete_member( $training_id )
    {
		$member_id = $this->request->getPost('member_id');

		if (empty($member_id) || empty($training_id)) {
			return $this->response->setJSON(['status' => 'error']);
		}

		$this->trainingMembers->where([
            'training_id' => $training_id
        ])->delete($member_id);

		return $this->response->setJSON(['status' => 'success']);
    }

    public function getUsersForAutocomplete()
    {
        $searchTerm = $this->request->getVar('query');

        // Sanitize the search term (to prevent malicious input)
        $searchTerm = filter_var($searchTerm, FILTER_SANITIZE_STRING);

        $userModel = new Users();

        $users = $userModel
            ->groupStart()
                ->like('firstname', $searchTerm)
                ->orLike('middlename', $searchTerm)
                ->orLike('lastname', $searchTerm)
            ->groupEnd()
            ->findAll(10); // Limit to 10 results

        return $this->response->setJSON( $users );
    }

    public function index( $training_id ): string
    {
        $data = array();
        $this->header->getHeader( $data );

        $data['training'] = $this->trainings->find( $training_id );

        $data["current_training"] = $data["training"] != false ? $training_id : false;
		
        if (!$data['training']) {
			// Handle the case when the assignment is not found
			//return redirect()->to('/some-error-page')->with('error', 'Assignment not found.');
			echo "Training not found.";
			exit;
		}

        $data['members'] = $this->trainingMembers->getMembers( $training_id );

        $data['text_editor'] = service('text_editor');

        return view('admin/training', $data);
    }
}