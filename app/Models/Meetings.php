<?php

namespace App\Models;

use CodeIgniter\Model;

class Meetings extends Model
{
    protected $table      = 'meetings';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'name', 'info', 'intro'];
}

