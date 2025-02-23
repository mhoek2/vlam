<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingAssignmentEntryProperties extends Model
{
    protected $table      = 'training_assignment_entry_properties';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'entry_id', 'content', 'sort_order'];
}