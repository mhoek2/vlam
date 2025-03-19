<?php

namespace App\Controllers\Front\DashboardModules;

class DashboardModule
{
	protected $sort = 100;
	protected $css_class = '';
	protected $visible = true;
	
	function getSort(){
		return $this->sort;
	}
	
	function getCssClass(){
		return $this->css_class;
	}
	
	function getVisibility(){
		return $this->visible;
	}	
}
	 