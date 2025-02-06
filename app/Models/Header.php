<?php

namespace App\Models;

use CodeIgniter\Model;

class Header extends Model
{
    private static function generateShortName( $user ) {
        $first_name = $user['firstname'] ?? '';
        $last_name = $user['lastname'] ?? '';

        return strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1));
    }

    public function getHeader( &$data ) {
        $header = array();
        $header["username"] = auth()->user()->username;
        $header["name"] = auth()->user()->name;
        $header["user"] = auth()->user()->toRawArray();
        $header["user"]["shortname"] = $this->generateShortName( $header["user"] );

        //auth()->user()->username;
        //Get logged-in User email:
        //
        //auth()->user()->getEmail();
        //Get the 'date & time' when the logged-in User account was created:
        //
        //auth()->user()->created_at->toDateTimeString();
        //Get all logged-in User data.
        //
        //auth()->user()->toRawArray();

        $data["header"] = view('header', $header);
    }
}

