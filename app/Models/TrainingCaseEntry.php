<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingCaseEntry extends Model
{
    protected $table      = 'training_case_entry';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'type', 'name', 'sort_order', 'info', 'case_id'];
    public $type_enum = [ 
        ['type' => 'mcq',               'name' => 'Multiple Choice'], 
        ['type' => 'text_input',        'name' => 'Text Input'], 
        ['type' => 'text_separator',    'name' => 'Text Separator']
    ];

}