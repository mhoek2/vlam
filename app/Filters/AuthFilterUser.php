<?php
// app/Filters/AuthFilter.php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilterUser implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
		// https://shield.codeigniter.com/quick_start_guide/using_authorization/
		$user = auth()->user();

		if($user == NULL)
		{
			return redirect()->to('/login');
		}

		
		if (!$user->inGroup('user')) {	
			if ($user->inGroup('admin')) {	
				return redirect()->to('/admin');
			}

			return redirect()->to('/404');
		}
		
		//if (!auth()->user()->can('test.control')) {
		//	return redirect()->to('/login');
		//}
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No actions needed after the request
    }
}