<?php

namespace App\Controllers\Front\DashboardModules;

class DashboardModule
{
	protected $sort = 100;
	protected $css_class = '';
	
	function getSort(){
		return $this->sort;
	}
	
	function getCssClass(){
		return $this->css_class;
	}
}
	 