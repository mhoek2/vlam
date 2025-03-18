<?php

namespace App\Controllers\Front\DashboardModules;

use App\Controllers\Front\DashboardModules\DashboardModule;

class ExampleDashboardModule extends DashboardModule
{
	protected $sort = 10;
	
    public function index( &$data ) : string
    {
		$this->data = $data;
		
		$training_meta = service('user_meta');

		$this->data['meta'] = $training_meta->find( 'case_meta' );
		
		if ( is_null($this->data['meta']) )
			return "";
		
		return view('front/dashboard_modules/example', $this->data);
	}
}
	 