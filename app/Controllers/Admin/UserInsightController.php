<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use CodeIgniter\Validation\Validation;
use CodeIgniter\I18n\Time;

use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Traits\Viewable;
use CodeIgniter\Shield\Validation\ValidationRules;

use App\Models\Users;
use App\Models\Meetings;

use App\Models\Assignments;					// for admin debug
use App\Models\AssignmentEntry;				// for admin debug
use App\Models\AssignmentEntryProperties;	// for admin debug
use App\Models\AssignmentResult;			// for admin debug
use App\Models\TrainingAssignments;
use App\Models\TrainingAssignmentEntry;
use App\Models\TrainingAssignmentEntryProperties;
use App\Models\TrainingAssignmentResult;

use App\Models\Cases;						// for admin debug
use App\Models\CaseEntry;					// for admin debug
use App\Models\CaseEntryProperties;			// for admin debug
use App\Models\CaseResult;					// for admin debug
use App\Models\TrainingCases;
use App\Models\TrainingCaseEntry;
use App\Models\TrainingCaseEntryProperties;
use App\Models\TrainingCaseResult;

class UserInsightController extends BaseController
{
	protected $userModel;
	
    public function __construct() {
		$this->userModel = new Users();
    }
	
	private function set_models( int $user_id )
	{
		//
		// Fetch training tree
		// 
		// todo:
		// for admin" the 'leading' training data tables.
		// for participants" the actual training data tables.
		//
		
		// admin
		//$this->meetings = new Meetings();
		//$this->assignments = new Assignments();
		//$this->cases = new Cases();
		
		$this->meetings = new Meetings();
		
		$this->assignments					= new TrainingAssignments();
		$this->assignmentEntry 				= new TrainingAssignmentEntry();
        $this->assignmentEntryProperties 	= new TrainingAssignmentEntryProperties();
        $this->assignmentResult 			= new TrainingAssignmentResult();
		
		/*if ( !is_null($this->data['user']['training_id']) ) {
			$this->assignments->setTrainingId( $this->data['user']['training_id'] );
		}*/

		// Cases
		$this->cases 						= new TrainingCases();
		$this->caseEntry 					= new TrainingCaseEntry();
		$this->caseEntryProperties			= new TrainingCaseEntryProperties();
        $this->caseResult 					= new TrainingCaseResult();
	}
	
	
	private function fetch_entry_properties( array $properties, array &$saved_results, array &$entry )
	{		
		// set stored value for this entry, (property_id or the dynamic user input value)
		$entry['value'] = $saved_results[$entry['id']] ?? '';			
		$entry['properties'] = [];
		
		foreach( $properties as $property )
		{
			if ( $property['entry_id'] !== $entry['id'] )
				continue;

			// Mark property as selected if it exists in saved results - used for eg: mcq entry group (selects)
			$property['selected'] = isset($saved_results[$entry['id']]) && is_array($saved_results[$entry['id']]) && 
				in_array($property['id'], $saved_results[$entry['id']]);

			array_push( $entry['properties'], $property );
		}
	}
	
	private function fetch_entries( int $user_id, int $id, $id_key, &$result_object, &$entry_object, &$property_object )
	{
        // Entries
        $this->data['entries'] = $entry_object->where($id_key, $id)->orderBy('sort_order', 'ASC')->findAll();
        $this->data['has_entries'] = empty($this->data['entries']);
		$this->data['entry_types'] = $entry_object->type_enum;

        // Entry properties
		$this->data['properties'] = $property_object->orderBy('sort_order', 'ASC')->findAll();
		
		// Get saved user property ids and values
		// create array $saved_results with structure:
		// [entry_id] => property_id !== null) ? (array)json_decode(property_id) : value
		// if property_id is set to 1 (mcq), value contains integer list of selected property_id's
		$saved_properties = $result_object->where('user_id', $user_id)->where($id_key, $id)->select(['property_id', 'entry_id', 'value'])->get()->getResultArray();
        $saved_results = array_reduce($saved_properties, function ($result, $property) {
			$result[$property['entry_id']] = !is_null($property['property_id']) ? json_decode($property['value'], true) : $property['value'];
			return $result;
		}, []);
		
        foreach( $this->data['entries'] as $entry_id => &$entry )
        {
			// should never happen!
			// this is a fail-safe, assignmentEntry Model has query overrides.
			if (!$entry_object->valid_type($entry['type'])) 
			{
				unset($this->data['entries'][$entry_id]);
				continue;
			}

			$this->fetch_entry_properties( $this->data['properties'], $saved_results, $entry );
        }
	}
	
	
	
	private function get_assignment_result( int $user_id, int $assignment_id )
	{
		$this->set_models( $user_id );
		
		$this->fetch_entries( $user_id, $assignment_id, 
			'assignment_id', 
			$this->assignmentResult, 
			$this->assignmentEntry, 
			$this->assignmentEntryProperties
		);
		
		return view('admin/insight_result/assignment', $this->data);
	}
	
	private function get_case_result( int $user_id, int $case_id )
	{
		$this->set_models( $user_id );
		
		$this->fetch_entries( $user_id, $case_id, 
			'case_id', 
			$this->caseResult, 
			$this->caseEntry, 
			$this->caseEntryProperties
		);
		
		return view('admin/insight_result/case', $this->data);
	}
	
	public function get_result( int $user_id)
	{
		$assignment_id = (int)$this->request->getPost('assignment_id');
		$case_id = (int)$this->request->getPost('case_id');

		$selected_user = $this->userModel->getUser( $user_id );
		
		if ( empty($selected_user) && isset($selected_user[0]) )
			die('invalid user!');
		
		if ( empty($selected_user[0]['training_id']))
			die('user not in a training!');
		
		$html = '';
		
		// get assignment
		if ( $assignment_id && !$case_id ) {
			$html = $this->get_assignment_result( $user_id, $assignment_id ); 
		}
		
		// get case
		if ( $assignment_id && $case_id ) {
			$html = $this->get_case_result( $user_id, $case_id ); 
		}
		
		return $this->response->setJSON([
			'status' 			=> 'success', 
			'html'				=> $html, 
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
    public function index( int $user_id ): string
    {
		// User
		$selected_user = $this->userModel->getUser( $user_id );
		
		if ( empty($selected_user) && isset($selected_user[0]) )
			die('invalid user!');
		
		if ( empty($selected_user[0]['training_id']))
			die('user not in a training!');
		
		//
		// Fetch training tree
		// 
		// todo:
		// this needs to be the training data, admin fetches from leading tables..
		//
		//$this->meetings = new Meetings();
		//$this->assignments = new Assignments();
		$this->set_models( $user_id );
		
		$training_tree = [];
		
		foreach( $this->meetings->findAll() as $meeting )
		{
			$training_tree[$meeting['id']] = [
				'name' => $meeting['name'],
				'info' => $meeting['info'],
				'assignments' => []
			];
			
			$assignments = $this->assignments->where(['training_id' => $selected_user[0]['training_id'], 'meeting_id' => $meeting['id']])->findAll();
			
			foreach( $assignments as $assignment )
			{
				$training_tree[$meeting['id']]["assignments"][$assignment['id']]['assignment'] = $assignment['name'] . " " . $assignment['info'];
				
				$cases = $this->cases->where(['assignment_id' => $assignment['id']])->findAll();
				foreach( $cases as $case )
				{
					$training_tree[$meeting['id']]["assignments"][$assignment['id']]['cases'][$case['id']] = $case['name'] . " " . $case['info'];
				}
			}
		}

		$this->data['selected_user'] = $selected_user[0];
		$this->data['training_tree'] = &$training_tree;
		
		load_header( $this->data );
		load_footer( $this->data );
		
        return view('admin/user_insight', $this->data);
    }	
}