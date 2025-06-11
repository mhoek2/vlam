<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;

use App\Models\Uploads;

class DownloadController extends BaseController
{

    public function index( $any )
    {
		static $uploads = new Uploads();
		$permission = false;
		
		//$segments = service('uri')->getSegments();
		$segments = $this->request->getUri()->getSegments();

		array_shift($segments);
		$filepath = implode('/', $segments);

		$path = WRITEPATH . $filepath;

		$filedata = $uploads->where('path', $filepath)->find()[0];
		
		if ( is_null($filedata) || !file_exists($path) ) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException("Not found");
		}
		
		// global file, only need user session ( user session check is redundant )
		if ( (int)$filedata['global'] === 1 && $this->data['user'] ){
			$permission = true;
		}

		// own file
		if ( $filedata['user_id'] === $this->data['user']['id'] ) {
			$permission = true;
		}

		// not own file, but admin can open it
		else if ( $this->data['user']['is_admin'] ) {
			$permission = true;
		}
		
		// check if file owner share same training.
		else if ( $this->data['user'] && !is_null($this->data['user']['training_id']) )
		{
			if ($this->user_in_training($filedata['user_id'], $this->data['user']['training_id']) )
			{
				// finally, check if file is sharable/public ..
				// this is not implemented yet!
				//
				// think user profile picture etc, will be a path like : writable/uploads/user_data/*/public/*.*
				//$permission = true;
				//echo "same training";
			}
		}
		
		
		if ( !$permission ) {
			return response()
				->setStatusCode(403)
				->setBody('You do not have permission.')
				->send();
		}
		
		return $this->response->download($path, null);
    }
}
