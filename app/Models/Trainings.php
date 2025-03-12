<?php

namespace App\Models;

use CodeIgniter\Model;

use App\Models\TrainingUsers;

class Trainings extends Model
{
    protected $table      = 'trainings';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'name', 'started', 'stopped', 'created_at'];

    public function getTrainingsWithMemberCount()
    {
        return $this->select('trainings.*, COUNT(training_users.user_id) AS member_count') 
                    ->join('training_users', 'training_users.training_id = trainings.id', 'left')
                    ->groupBy('trainings.id') 
                    ->findAll();
    }
}