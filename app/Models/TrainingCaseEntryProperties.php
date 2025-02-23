<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingCaseEntryProperties extends Model
{
    protected $table      = 'training_case_entry_properties';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'entry_id', 'content', 'sort_order'];
}