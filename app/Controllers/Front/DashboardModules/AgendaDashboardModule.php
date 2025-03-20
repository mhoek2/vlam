<?php

namespace App\Controllers\Front\DashboardModules;

use App\Controllers\Front\DashboardModules\DashboardModule;

/**
 * Dashboard Module
 *
 * @package App\Controllers\Front\DashboardModules
 *
 */
class AgendaDashboardModule extends DashboardModule
{
	protected int $sort = 10;

    public function index( &$data ) : string
    {
		$this->data = $data;

		return view('front/dashboard_modules/agenda', $this->data);
	}
}
	 