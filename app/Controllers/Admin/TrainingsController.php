<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use CodeIgniter\I18n\Time;

use App\Models\Trainings;
use App\Models\TrainingUsers;

class TrainingsController extends BaseController
{
	protected $trainings;	
	protected $trainingMembers;	
	
    public function __construct() {
        $this->trainings = new Trainings();
        $this->trainingMembers = new TrainingUsers();
    }

    public function delete_training()
    {
		$training_id = $this->request->getPost('training_id');

		if (empty($training_id)) {
            return $this->response->setJSON(['status' => 'error', 'new_csrf_token'=> csrf_hash()]);
        }

        $members =  $this->trainingMembers->hasMembers($training_id);

        if ($members)
            return $this->response->setJSON(['status' => 'error', 'training has members!', 'new_csrf_token'=> csrf_hash()]);

        // check if training is in progress still?

		$this->trainings->delete($training_id);

		return $this->response->setJSON(['status' => 'success', 'new_csrf_token'=> csrf_hash()]);
    }

    public function add_training()
    {
		$this->trainings->insert([
			'name' 			=> 'Nieuwe training',
            'created_at' 	=> Time::now()
        ]);

		$insert_id = $this->trainings->insertID();

		return $this->response->setJSON([
			'status' => 'success', 
			'redirect_url'	=> base_url(route_to('admin.training', $insert_id)),
			'training_id' => $insert_id,
			'new_csrf_token'=> csrf_hash(),
		]);
    }

    public function index(): string
    {
		// Training
        $this->data['trainings'] = $this->trainings->getTrainingsWithMemberCount();

		load_header( $this->data );
		load_footer( $this->data );
		
        return view('admin/trainings', $this->data);
    }
}