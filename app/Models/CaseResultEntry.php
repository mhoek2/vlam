<?php

namespace App\Models;

use CodeIgniter\Model;

class CaseResultEntry extends Model
{
    protected $table      = 'case_result_entry';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'result_id', 'name', 'value', 'type'];
}