<?php

namespace App\Models;

use CodeIgniter\Model;

class Assignments extends Model
{
    protected $table      = 'assignments';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'meeting_id', 'name', 'sort_order', 'intro', 'outro', 'info', 'sub_assignment', 'created_at'];
}