<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\Assignments;

class AssignmentsController extends BaseController
{
    protected $assignments;

    public function __construct()
    {
        $this->assignments = new Assignments();
    }
		
	public function save_order()
	{
		$sort_order = $this->request->getPost('sort_order');
		
        foreach ($sort_order as $order => $id) {
           $this->assignments->update($id, ['sort_order' => $order]);
        }

        return $this->response->setJSON(['status' => 'success']);
	}
}
