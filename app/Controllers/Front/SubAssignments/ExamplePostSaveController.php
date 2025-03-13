<?php

namespace App\Controllers\Front\SubAssignments;

use App\Controllers\Front\BaseController;


class ExamplePostSaveController extends BaseController
{
    public function index( int $meeting_id, int $assignment_id )
    {
		// Post-save logic for storing custom data via service('user_meta') after case/assignment completion.
		// Custom logic may be required to store additional user-specific information in certain scenarios.
		//
		// example:
		// $user_meta = service('user_meta');
		// $user_meta->save( 'key', 'value', /*(Optional) user_id*/ );
		// $record = $user_meta->find( 'key', /*(Optional) user_id*/ );
		
		// Additionaly, For assignments only:
		// This can fully override an assignment if no entries exist. 
		// If selected, the Controller & View will be displayed directly, enabling a completely custom assignment.
		
		$meeting_id 	= (int) $meeting_id;
		$assignment_id 	= (int) $assignment_id;

		$assignment = $this->get_assignment($assignment_id);
		$result = $this->get_assignment_results($assignment_id);
	
		
		$training_meta = service('user_meta');
		$training_meta->save( 'assignment_meta', json_encode($result) );
		
		// redirect, this is just a post action
		$this->response->redirect( base_url(route_to('front.meeting', $meeting_id)) );
		return "";
    }
}
