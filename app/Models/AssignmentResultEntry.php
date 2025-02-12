<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentResultEntry extends Model
{
    protected $table      = 'assignment_result_entry';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'result_id', 'name', 'value', 'type'];
}