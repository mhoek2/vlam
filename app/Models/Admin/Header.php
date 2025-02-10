<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Header extends Model
{
    private static function generateShortName( $user ) {
        $first_name = $user['firstname'] ?? '';
        $last_name = $user['lastname'] ?? '';

        return strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1));
    }
    private function getUser() {
        $user = auth()->user();

        if($user == NULL)
            return false;

        $data = $user->toRawArray();
        $data["shortname"] = $this->generateShortName( $data );

        $data["is_admin"] = $user->inGroup('admin');

        return($data);
    }

    public function getHeader( &$data ) {
        $header = array();

		$header["user"] = $this->getUser();

        $data["header"] = view('admin/header', $header);
    }
}
