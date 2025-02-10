<?php

namespace App\Models;

use CodeIgniter\Model;

class Assignment extends Model
{
    protected $table      = 'assignment_entry';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'type', 'name', 'sort_order', 'info'];
}