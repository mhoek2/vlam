<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    public function isLoggedIn()
    {
        // Check if user is logged in by verifying session data
        if (session()->has('user_id')) {
            return false;
        }
        return true;
    }

    public function isAdmin()
    {
        // Check if user is logged in by verifying session data
        if ( !$this->isLoggedIn() ) {
            return false;
        }

        // Check if user is logged in as admin
        // ..

        return true;
    }
}

