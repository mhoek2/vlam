<?php

namespace App\Models;

use CodeIgniter\Model;

class Cases extends Model
{
    protected $table      = 'cases';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'assignment_id', 'name', 'sort_order', 'intro', 'outro', 'info', 'created_at'];
}