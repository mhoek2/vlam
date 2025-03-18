<?php

if (! function_exists('get_dashboard_modules')) {
	function get_dashboard_modules( &$data )
	{
		$modules = [];
		
		$dir = APPPATH . 'Controllers/Front/DashboardModules';
		$postfix = 'DashboardModule.php';
		
		foreach (glob($dir . '/*'. $postfix) as $file) {
			$controller_name = basename($file, '.php');
			$controller_class = "App\Controllers\Front\DashboardModules\\" . $controller_name;
			
			if (basename($file) === $postfix)
				continue;
			
			if (class_exists($controller_class)) 
			{
				$controller = new $controller_class();
				$exists = method_exists($controller, 'index');
				
				$modules[] = [
					'view' 		=> $exists ? $controller->index($data) 		: sprintf("index not found for: %s", $controller_class),
					'sort' 		=> $exists ? $controller->getSort()			: 100,
					'css_class' => $exists ? $controller->getCssClass()		: ''
				];
			}
		}
		
		usort($modules, function($a, $b) {
			return $a['sort'] <=> $b['sort']; // Compare based on the 'sort' value
		});
		
		return $modules;
	}
}