<?php

namespace App\Controllers\Front\DashboardModules;

use App\Controllers\Front\DashboardModules\DashboardModule;

class AgendaDashboardModule extends DashboardModule
{
	protected $sort = 10;
	protected $css_class = 'wide';
	
    public function index(  ) : string
    {
		$this->data = [];

		return view('front/dashboard_modules/agenda', $this->data);
	}
}
	 