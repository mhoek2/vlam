<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

class DownloadController extends BaseController
{
    public function index( $any )
    {

		//$segments = service('uri')->getSegments();
		$segments = $this->request->getUri()->getSegments();

		array_shift($segments);
		$filepath = implode('/', $segments);

		$path = WRITEPATH . $filepath;

		if (!file_exists($path)) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException("File not found");
		}

		return $this->response->download($path, null);
    }
}
