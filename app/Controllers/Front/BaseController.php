<?php

namespace App\Controllers\Front;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\User;
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

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['front/sidebar', 'front/header'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
	private function initSessionController(){
        if (!$this->data['user'])
            return;

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
        $this->meetings 	= new Meetings();
		
	    $this->data = array();

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
}
