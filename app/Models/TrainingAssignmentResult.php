<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingAssignmentResult extends Model
{
    protected $table      = 'training_assignment_result';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'user_id', 'assignment_id', 'entry_id', 'property_id'];
}