<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use CodeIgniter\I18n\Time;

use App\Models\Meetings;
use App\Models\Trainings;
use App\Models\TrainingUsers;
use App\Models\TrainingSchedule;
use App\Models\Users;

use Config\CKeditor;

// used for cloning
use App\Models\Assignments;
use App\Models\AssignmentEntry;
use App\Models\AssignmentEntryProperties;
use App\Models\Cases;
use App\Models\CaseEntry;
use App\Models\CaseEntryProperties;

use App\Models\TrainingAssignments;
use App\Models\TrainingAssignmentEntry;
use App\Models\TrainingAssignmentEntryProperties;
use App\Models\TrainingCases;
use App\Models\TrainingCaseEntry;
use App\Models\TrainingCaseEntryProperties;

class TrainingController extends BaseController
{
    public function __construct() {
		$this->meetings 		= new Meetings();
        $this->trainings 		= new Trainings();
        $this->trainingMembers 	= new TrainingUsers();
        $this->TrainingSchedule = new TrainingSchedule();
    }

	private function clearTraining( int $training_id )
	{
		$trainingAssignments = new TrainingAssignments();
		$trainingAssignments->where('training_id', $training_id)->delete();	
	}
		
	private function cloneAssignmentsAndCases( int $training_id )
	{
		// Explanation:
		// 
		// There can be scenarios, where an admin wants to update 'assignments' or 'cases'.
		// This cannot happen when a training is in progress, this may result into unreferenced relations between assignments/questions/answers/cases.
		// ( imagine an assignment, question or answer is removed while a user is interacting with it )
		// a solution would be to soft-lock the entire assignment structure whenever a 'training' is in progress.
		// however, IF in the future more admins are assigned with different locations, with overlapping training schemes, there might ALWAYS
		// be a 'training' in progress, communicating to alter an assignment or case can prove to be challenging.
		//
		// Thats why is opted to clone all assignments and case data into a dedicated table structure specific for each training.
		// This means that once a training is started, there is no way to alter the assignments in case of errors/typos.
		// but does ensure no errors are raised when an assignment/question/case is removed.
		// this method also makes storing user data easier and cleaner.
		// every assignment simply has a clone of the 'at that time' latest assignments and case structure.
		//
		// a offline 'handbook' system is no different, pupils do not get new handbooks during a semester.

		$trainingAssignments 				= new TrainingAssignments();
        $trainingAssignmentEntry 			= new TrainingAssignmentEntry();
        $trainingAssignmentEntryProperties 	= new TrainingAssignmentEntryProperties();
        $trainingCases 						= new TrainingCases();
        $trainingCaseEntry 					= new TrainingCaseEntry();
        $trainingCaseEntryProperties 		= new TrainingCaseEntryProperties();
		
		//
		// Clear first, just in case. 
		// Using CASCADED foreign relations to remove entries and properties including linked cases.
		//
		$this->clearTraining( $training_id );
		
		//
		// Clone assignments
		//
		$oldToNewAssignmentIdMap = [];
		$oldToNewAssignmentEntryIdMap = [];
		
		$assignments = (new Assignments())->findAll();
		foreach ($assignments as $assignment) 
		{
			$trainingAssignments->insert([
				'training_id'	=> $training_id,
				'meeting_id' 	=> $assignment['meeting_id'],
				'name' 			=> $assignment['name'],
				'sort_order' 	=> $assignment['sort_order'],
				'intro' 		=> $assignment['intro'],
				'outro' 		=> $assignment['outro'],
				'info' 			=> $assignment['info'],
				'sub_assignment'=> $assignment['sub_assignment'],
			]);

			$oldToNewAssignmentIdMap[ $assignment['id'] ] = $trainingAssignments->getInsertID();	// map the cloned assignment id
		}
		
		$assignmentEntries = (new AssignmentEntry())->whereIn('assignment_id', array_column($assignments, 'id'))->findAll();
		foreach ($assignmentEntries as $entry) 
		{
			$trainingAssignmentEntry->insert([
				'assignment_id' => $oldToNewAssignmentIdMap[ $entry['assignment_id'] ],	// Set the cloned assignment id
				'sort_order' 	=> $entry['sort_order'],
				'name' 			=> $entry['name'],
				'info' 			=> $entry['info'],
				'type' 			=> $entry['type']
			]);
			
			$oldToNewAssignmentEntryIdMap[ $entry['id'] ] = $trainingAssignmentEntry->getInsertID();	// map the cloned assignment entry id
		}
		
		$entryProperties = (new AssignmentEntryProperties())->whereIn('entry_id', array_column($assignmentEntries, 'id'))->findAll();
		foreach ($entryProperties as $property) {
			$trainingAssignmentEntryProperties->insert([
				'entry_id' 		=> $oldToNewAssignmentEntryIdMap[ $property['entry_id'] ],	// set the cloned assignment entry id
				'content' 		=> $property['content'],
				'sort_order' 	=> $property['sort_order'],
			]);
		}
		
		//
		// Clone cases
		//
		$oldToNewCasesIdMap = [];
		$oldToNewCasesEntryIdMap = [];
		
		$cases = (new Cases())->whereIn('assignment_id', array_column($assignments, 'id'))->findAll();
		foreach ($cases as $case) 
		{
			$trainingCases->insert([
				'assignment_id' 	=> $oldToNewAssignmentIdMap[ $case['assignment_id'] ],	// Set the cloned assignment id
				'sort_order' 		=> $case['sort_order'],
				'name' 				=> $case['name'],
				'intro' 			=> $case['intro'],
				'outro'	 			=> $case['outro'],
				'info' 				=> $case['info'],
				'complete_action' 	=> $case['complete_action'],
			]);

			$oldToNewCasesIdMap[ $case['id'] ] = $trainingCases->getInsertID();	// map the cloned case id
		}
		
		$caseEntries = (new CaseEntry())->whereIn('case_id', array_column($cases, 'id'))->findAll();
		foreach ($caseEntries as $entry) 
		{
			$trainingCaseEntry->insert([
				'case_id' 		=> $oldToNewCasesIdMap[ $entry['case_id'] ],	// Set the cloned case id
				'sort_order' 	=> $entry['sort_order'],
				'name' 			=> $entry['name'],
				'info' 			=> $entry['info'],
				'type' 			=> $entry['type']
			]);
			
			$oldToNewCasesEntryIdMap[ $entry['id'] ] = $trainingCaseEntry->getInsertID();	// map the cloned case entry id
		}
		
		$caseProperties = (new CaseEntryProperties())->whereIn('entry_id', array_column($caseEntries, 'id'))->findAll();
		foreach ($caseProperties as $property) {
			$trainingCaseEntryProperties->insert([
				'entry_id' 		=> $oldToNewCasesEntryIdMap[ $property['entry_id'] ],	// set the cloned case entry id
				'content' 		=> $property['content'],
				'sort_order' 	=> $property['sort_order'],
			]);
		}
	}
	
	public function start( int $training_id )
	{
		$this->trainings->update($training_id, [
            'started' => Time::now(),
        ]);
		
		$this->cloneAssignmentsAndCases( $training_id );
		
		return $this->response->setJSON([
			'status' 			=> 'success', 
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
	public function stop( int $training_id )
	{
		$this->trainings->update($training_id, [
            'stopped' => Time::now(),
        ]);
		
		return $this->response->setJSON([
			'status' 			=> 'success', 
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
	public function force_reset( int $training_id )
	{
		$this->clearTraining( $training_id );	// redundant, happens in start() as well

		$this->trainings->update($training_id, [
            'started' => NULL,
            'stopped' => NULL,
        ]);
		
		return $this->response->setJSON([
			'status' 			=> 'success', 
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
    public function save( $training_id )
    {
        $name = $this->request->getPost('name');

		$this->trainings->update($training_id, [
            'name' => $name,
        ]);
		
		$meeting_ids = $this->request->getPost('meeting_ids');
        $meeting_dates = $this->request->getPost('meeting_dates');

		foreach ( $meeting_ids as $meeting_id )
		{
			$this->TrainingSchedule->replace([ 
				'training_id' 	=> $training_id, 
				'meeting_id' 	=> $meeting_id,
				'date' 			=> $meeting_dates[$meeting_id]
            ]);
		}

		return $this->response->setJSON([
			'message' 		=> 'Form submitted successfully!',
			'new_csrf_token'=> csrf_hash(),
		]);
    }

    public function add_member( $training_id )
    {
        $user_id = $this->request->getPost('user_id');

		$this->trainingMembers->replace([ 
			'training_id' 	=> $training_id, 
			'user_id' 		=> $user_id
            ]
		);

        return $this->response->setJSON([
			'status' 		=> 'success', 
			'message' 		=> 'Form submitted successfully!',
			'new_csrf_token'=> csrf_hash(),
		]);
    }

    public function delete_member( $training_id )
    {
		$member_id = $this->request->getPost('member_id');

		if (empty($member_id) || empty($training_id)) {
			return $this->response->setJSON(['status' => 'error']);
		}

		$this->trainingMembers->where([
            'training_id' 	=> $training_id
        ])->delete($member_id);

		return $this->response->setJSON([
			'status' 		=> 'success',
			'new_csrf_token'=> csrf_hash(),
		]);
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
		// Meeting
		$this->data['meetings'] = $this->meetings->findAll();

		$this->data['meeting_schedule'] = $schedule = $this->TrainingSchedule->getSchedule( $training_id );

		// Training
        $this->data['training'] = $this->trainings->find( $training_id );

		$this->data['training_started'] = !is_null($this->data['training']['started']);
		$this->data['training_stopped'] = !is_null($this->data['training']['stopped']);
		
        $this->data["current_training"] = $this->data["training"] != false ? $training_id : false;
		
        if (!$this->data['training']) {
			// Handle the case when the assignment is not found
			//return redirect()->to('/some-error-page')->with('error', 'Assignment not found.');
			echo "Training not found.";
			exit;
		}

        $this->data['members'] = $this->trainingMembers->getMembers( $training_id );

        $this->data['text_editor'] = service('text_editor');

		load_header( $this->data );
		load_footer( $this->data );
		
        return view('admin/training', $this->data);
    }
}