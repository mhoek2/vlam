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
		
		// Completion action logic below
    }
}
