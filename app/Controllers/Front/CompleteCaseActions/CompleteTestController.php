<?php

namespace App\Controllers\Front\CompleteCaseActions;

use App\Controllers\Front\BaseController;


class CompleteTestController extends BaseController
{
    public function index( $meeting_id, $assignment_id, $case_id )
    {
		$meeting_id 	= (int) $meeting_id;
		$assignment_id 	= (int) $assignment_id;
		$case_id 		= (int) $case_id;

		$case = $this->cases->find($case_id);
		
		if ( is_null($case) )
			die("Case complete action failed!");
		
		
		// This is the post-save logic for storing custom data 
		// using service('user_meta') after a case is completed. 
		// For certain cases or questions, custom logic might be needed to store additional information 
		// for the user
		
		// Completion action logic below
		
		// example:
		// $training_meta = service('user_meta');
		// $training_meta->save( 'key', 'value', /*(Optional) user_id*/ );
		
		$training_meta = service('user_meta');
		$training_meta->save( 'key', 'value' );
		
		echo "debug";
		exit;
    }
}
