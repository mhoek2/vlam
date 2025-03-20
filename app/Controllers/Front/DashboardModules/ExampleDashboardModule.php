<?php

namespace App\Controllers\Front\DashboardModules;

use App\Controllers\Front\DashboardModules\DashboardModule;

/**
 * Dashboard Module
 *
 * @package App\Controllers\Front\DashboardModules
 *
 */
class ExampleDashboardModule extends DashboardModule
{
	protected int $sort = 5;
	protected string $css_class = 'wide';
	
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
	 