<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['firstname', 'middlename', 'lastname'];

}

