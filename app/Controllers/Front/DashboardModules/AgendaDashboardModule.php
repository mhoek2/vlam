<?php

namespace App\Controllers\Front\DashboardModules;

use App\Controllers\Front\DashboardModules\DashboardModule;
use App\Models\TrainingSchedule;

/**
 * Dashboard Module
 *
 * @package App\Controllers\Front\DashboardModules
 *
 */
class AgendaDashboardModule extends DashboardModule
{
	protected int $sort = 10;
	protected string $css_class = 'agenda';

    public function index( &$data ) : string
    {
		$this->data = $data;
	
		$this->data['schedule'] = [];
		
		if ( $this->data['user'] && !is_null($this->data['user']['training_id']) )
			$this->data['schedule'] = (new TrainingSchedule())->getUserSchedule( $this->data['user']['training_id'] );
		
		return view('front/dashboard_modules/agenda', $this->data);
	}
}
	 