<?php

namespace App\Models;

use CodeIgniter\Model;

class Cases extends Model
{
    protected $table      = 'cases';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'meeting_id', 'name', 'sort_order', 'intro', 'info', 'created_at'];
}