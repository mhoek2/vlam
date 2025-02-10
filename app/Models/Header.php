<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\User;

class Header extends Model
{
    public function getHeader( &$data ) {
        $user = new User();

        $header = array();
		$header["user"] = $user->getUserInfo();

        $data["header"] = view('front/header', $header);
    }
}