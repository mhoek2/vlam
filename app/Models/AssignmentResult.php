<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentResult extends Model
{
    protected $table      = 'assignment_result';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'user_id', 'assignment_id', 'entry_id', 'property_id', 'value'];
}