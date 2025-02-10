<?php

namespace App\Models\Admin;

use CodeIgniter\Model;
use App\Models\User;

class Header extends Model
{
    public function getHeader( &$data ) {

        $user = new User();

        $header = array();
		$header["user"] = $user->getUserInfo();

        $data["header"] = view('admin/header', $header);
    }
}