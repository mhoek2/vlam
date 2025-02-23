<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingCases extends Model
{
    protected $table      = 'training_cases';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'assignment_id', 'name', 'sort_order', 'intro', 'outro', 'info', 'created_at'];
}