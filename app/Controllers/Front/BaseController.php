<?php

namespace App\Controllers\Front;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\User;
use App\Models\Trainings;

use App\Models\Meetings;					// for admin debug
use App\Models\Assignments;					// for admin debug
use App\Models\AssignmentEntry;				// for admin debug
use App\Models\AssignmentEntryProperties;	// for admin debug
use App\Models\AssignmentResult;			// for admin debug

use App\Models\TrainingMeetings;
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

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
	
	protected $data = [];
	protected $user;
	protected $meetings;
	protected $assignments;
	protected $assignmentEntry;
	protected $assignmentEntryProperties;
	protected $assignmentResult;
	protected $cases;
	protected $caseEntry;
	protected $caseEntryProperties;
	protected $caseResult;
	
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['download', 'csrf', 'user', 'front/dashboard', 'front/sidebar', 'front/header', 'front/footer'];

	private function validTrainingForUser( $user )
	{
		if ( !$user )
			return true;

		// Admin can always view a training (either a 'specific' training, or the Leading Training )
		// Simulate end-user role for an admin; continue reading in Models\User::getUserInfo()
		if ( $user["is_admin"] )
			return false;
		
		// End-user handling
		if ( !is_null($user["training_id"] ) )
		{
			$training = $this->get_training( $user["training_id"] );

			// Validate training state ( started, and not stopped )
			if ( $training && !is_null($training['started']) && is_null($training['stopped']))
				return false;
		}

		return true;
	}
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
	private function initSessionController()
	{
		if ( !$this->data['user'] )
			return;

		// Meeting (also visible when not assigned to a training on homepage )
		if ( $this->data['user'] && is_null($this->data['user']['training_id']) )
			$this->meetings 	= new Meetings();
		else
			$this->meetings 	= new TrainingMeetings();
		
		// Validate what training a user or admin is in, and if it is in what state.<br>
		// Perform redirects to home if the training has ended.
		$this->data['training_locked'] = $this->validTrainingForUser( $this->data['user'] );
		
		if ( $this->data['training_locked'] ) {
			if ( current_url() !== url_to('home') )
				$this->response->redirect( base_url(route_to('home')) );
			else
			{
				$this->meetings 	= new Meetings();
				return;
			}
		}
		
        // Assignment
		$this->assignments 					= is_null($this->data['user']['training_id']) ? new Assignments() 					: new TrainingAssignments();
        $this->assignmentEntry 				= is_null($this->data['user']['training_id']) ? new assignmentEntry() 				: new TrainingAssignmentEntry();
        $this->assignmentEntryProperties 	= is_null($this->data['user']['training_id']) ? new AssignmentEntryProperties() 	: new TrainingAssignmentEntryProperties();
        $this->assignmentResult 			= is_null($this->data['user']['training_id']) ? new AssignmentResult() 			    : new TrainingAssignmentResult();
		
		if ( !is_null($this->data['user']['training_id']) ) {
			$this->assignments->setTrainingId( $this->data['user']['training_id'] );
		}
		
        $this->data['assignments'] 			= NULL;
		$this->data['assignment'] 			= NULL;
		
		// Cases
		$this->cases 						= is_null($this->data['user']['training_id']) ? new Cases()						: new TrainingCases();
		$this->caseEntry 					= is_null($this->data['user']['training_id']) ? new CaseEntry()					: new TrainingCaseEntry();
		$this->caseEntryProperties			= is_null($this->data['user']['training_id']) ? new CaseEntryProperties()		: new TrainingCaseEntryProperties();
        $this->caseResult 					= is_null($this->data['user']['training_id']) ? new CaseResult() 				: new TrainingCaseResult();
    }

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
		
        $this->user 		= new User();
		
	    $this->data = [];

		// User
		$this->data['user'] = $this->user->getUserInfo();	
		
        $this->initSessionController();

		// Meeting
        $this->data['meetings'] 			= NULL;
        $this->data['meeting'] 				= NULL;
        $this->data["current_meeting"] 		= NULL;

        // Assignment
        $this->data['assignments'] 			= NULL;
		$this->data['assignment'] 			= NULL;
		
		// Cases
        $this->data['cases'] 				= NULL;
		$this->data['case'] 				= NULL;				
    }
	
	public function get_edit_route( string $route, ...$args )
	{
		if ( $this->user->isAdmin() )
			return base_url(route_to($route, ...$args));
		
		return false;
	}
	
	public function get_training( int $training_id )
	{
		$item = (new Trainings())->find($training_id);
		
		if ( is_null($item) ){
			die("Meeting not found.");
		}
		
		return $item;
	}
	
	public function get_meeting( int $meeting_id )
	{
		$item = $this->meetings->find( $meeting_id );
		
		if ( is_null($item) ){
			die("Meeting not found.");
		}
		
		return $item;
	}
	
	public function get_assignment( int $assignment_id )
	{
		$item = $this->assignments->find($assignment_id);
		
		if ( is_null($item) ){
			die("Assignment not found.");
		}
		
		return $item;
	}	
	
	/**
	 * Get case from database and make sure it exists
	 */
	public function get_case( int $assignment_id, int $case_id )
	{
		$item = $this->cases->find($case_id);

		if ( !$item || (int)$item['assignment_id'] !== (int)$assignment_id) {
			die("Case not found.");
		}
		
		return $item;
	}	
	
	/**
	 * Retrieves entry properties and maps property values based on user ID.
	 *
	 * This function fetches results from the given result object (assignment or case), joins it with the entry object, 
	 * and maps the corresponding property values using the property object.
	 *
	 * @param int    $id              The ID of the entry to fetch properties for.
	 * @param string $id_key          The column name used to filter results by ID.
	 * @param object &$result_object  The model instance representing the results table (passed by reference).
	 * @param object &$entry_object   The model instance representing the entry table (passed by reference).
	 * @param object &$property_object The model instance representing the property table (passed by reference).
	 *
	 * @return array An array of results with mapped property values. Returns an empty array if no user ID is found.
	 */
	public function get_entry_properties_result( $id, $id_key, &$result_object, &$entry_object, &$property_object )
	{
		$user_id = $this->data['user']['id'] ?? null;
		
		if ( !$user_id )
			return [];
		
		$results = $result_object->select(
				"{$result_object->table}.value, 
				 {$result_object->table}.property_id, 
				 {$result_object->table}.entry_id, 
				 {$entry_object->table}.name as entry_name"
			)
			->join($entry_object->table, "{$result_object->table}.entry_id = {$entry_object->table}.id", 'left')
			->where([
				"{$result_object->table}.user_id" => $user_id,
				"{$result_object->table}.$id_key" => $id
			])
			->orderBy("{$entry_object->table}.sort_order", 'ASC')
			->findAll();
		
		// Find and bind property names
		foreach ( $results as $index => $item )
		{
			$properties = json_decode($item['value'], true);
			
			if ( !is_array($properties) || is_null($item['property_id']) )
				continue;
			
			$property_ids = array_filter($properties, fn($prop_id) => $prop_id > 0);
			$results[$index]['value'] = [];
			
			if ( !empty($property_ids) ) 
			{
				// Fetch and map all properties using a single query
				$property_data = $property_object->whereIn('id', $property_ids)->findAll();
				$property_map = array_column($property_data, 'content', 'id');
				
				foreach ($property_ids as $property_id) 
				{
					if ( isset($property_map[$property_id]) ) 
					{
						$results[$index]['value'][$property_id] = $property_map[$property_id];
					}
				}
			}
		}
		
		return $results;
	}
	
	public function get_assignment_results( int $assignment_id )
	{
		return $this->get_entry_properties_result( 
			$assignment_id, 
			'assignment_id', 
			$this->assignmentResult, 
			$this->assignmentEntry, 
			$this->assignmentEntryProperties
		);
	}
	
	public function get_case_results( int $case_id )
	{
		return $this->get_entry_properties_result( 
			$case_id, 
			'case_id', 
			$this->caseResult, 
			$this->caseEntry, 
			$this->caseEntryProperties
		);
	}

}
