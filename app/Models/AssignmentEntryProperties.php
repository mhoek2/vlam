<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentEntryProperties extends Model
{
    protected $table      = 'assignment_entry_properties';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'entry_id', 'content', 'sort_order'];
}