<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class Home extends BaseController
{
    public function index(): string
    {
		load_header( $this->data );
		load_footer( $this->data );
		
        return view('front/landing', $this->data);
    }

	private function get_dashboard_modules()
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
				
				if (method_exists($controller, 'index'))
					$modules[] = [
						'module' => $controller->index(),
						'sort' => $controller->getSort(),
					];
				
				else
					$modules[] = [
						'module' => sprintf("index not found for: %s", $controller_class),
						'sort' => 100,
					];
			}
		}
		
		usort($modules, function($a, $b) {
			return $a['sort'] <=> $b['sort']; // Compare based on the 'sort' value
		});
		
		return array_column($modules, 'module');
	}
	
    public function application(): string
    {
        // Meetings
        $this->data['meetings'] = $this->meetings->findAll();
		
		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
		$this->data['dashboard_modules'] = $this->get_dashboard_modules();

        return view('front/dashboard', $this->data);
    }
}
