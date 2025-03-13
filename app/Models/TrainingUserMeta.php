<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingUserMeta extends Model
{
    protected $table      = 'training_user_meta';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'user_id', 'key', 'value', 'created_at'];
}

