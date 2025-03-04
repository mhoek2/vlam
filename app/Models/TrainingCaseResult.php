<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingCaseResult extends Model
{
    protected $table      = 'training_case_result';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'user_id', 'assignment_id', 'case_id', 'entry_id', 'property_id', 'value'];
}