<?php

namespace App\Controllers\Front\CompleteCaseActions;

use App\Controllers\Front\BaseController;


class CompleteTestController extends BaseController
{
	public function get_case( $case_id )
	{
		$case = $this->cases->find($case_id);
		
		if ( is_null($case) ){
			die("Case not found22.");
		}
		
		return $case;
	}

    public function index( $meeting_id, $assignment_id, $case_id ): string
    {
		$meeting_id 	= (int) $meeting_id;
		$assignment_id 	= (int) $assignment_id;
		$case_id 	= (int) $case_id;
	
		return "Post complete action";
    }
}
