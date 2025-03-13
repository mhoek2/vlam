<?php

namespace App\Controllers\Front\CompleteCaseActions;

use App\Controllers\Front\BaseController;


class ExamplePostSaveController extends BaseController
{
    public function index( int $meeting_id, int $assignment_id, int $case_id )
    {
		// Post-save logic for storing custom data via service('user_meta') after case/assignment completion.
		// Custom logic may be required to store additional user-specific information in certain scenarios.
		//
		// example:
		// $user_meta = service('user_meta');
		// $user_meta->save( 'key', 'value', /*(Optional) user_id*/ );
		// $record = $user_meta->find( 'key', /*(Optional) user_id*/ );
		
		$meeting_id 	= (int) $meeting_id;
		$assignment_id 	= (int) $assignment_id;
		$case_id 		= (int) $case_id;

		$case = $this->get_case( $assignment_id, $case_id );

		$training_meta = service('user_meta');
		$training_meta->save( 'case_meta', 'value' );
		
		// redirect, this is just a post action
		$this->response->redirect( base_url(route_to('front.meeting', $meeting_id )) );
		return "";
    }
}
