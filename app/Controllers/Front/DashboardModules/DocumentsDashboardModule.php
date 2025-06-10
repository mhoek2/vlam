<?php

namespace App\Controllers\Front\DashboardModules;

use App\Controllers\Front\DashboardModules\DashboardModule;
use App\Models\Uploads;

/**
 * Dashboard Module
 *
 * @package App\Controllers\Front\DashboardModules
 *
 */
class DocumentsDashboardModule extends DashboardModule
{
	protected int $sort = 15;
	protected string $css_class = 'documents';

    public function index( &$data ) : string
    {
		$this->data = $data;
	
		$this->data['documents'] = [];
		
		$this->uploads = new Uploads();
		
		if ( $this->data['user'] && ($this->data['user']['is_admin'] || !$this->data['training_locked']) )
			$this->data['documents'] = $this->uploads->where(['global' => 1])->findAll();
		
		return view('front/dashboard_modules/documents', $this->data);
	}
}
	 