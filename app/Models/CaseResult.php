<?php

namespace App\Models;

use CodeIgniter\Model;

class CaseResult extends Model
{
    protected $table      = 'case_result';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'user_id', 'assignment_id', 'case_id', 'entry_id', 'property_id', 'value'];
}