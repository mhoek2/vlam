<?php

namespace App\Controllers\Front\DashboardModules;

use App\Controllers\Front\DashboardModules\DashboardModule;

class ExampleDashboardModule extends DashboardModule
{
	protected $sort = 10;
	
    public function index(  ) : string
    {
		$this->data = [];
		
		$training_meta = service('user_meta');

		$this->data['meta'] = $training_meta->find( 'case_meta' );
		
		if ( is_null($this->data['meta']) )
			return "";
		
		return view('front/dashboard_modules/example_dashboard_module', $this->data);
	}
}
	 