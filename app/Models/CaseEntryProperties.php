<?php

namespace App\Models;

use CodeIgniter\Model;

class CaseEntryProperties extends Model
{
    protected $table      = 'case_entry_properties';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'entry_id', 'content', 'sort_order'];
}