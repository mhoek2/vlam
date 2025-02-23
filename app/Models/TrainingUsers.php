<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingUsers extends Model
{
    protected $table      = 'training_users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'training_id', 'user_id'];

    public function getMembers( $training_id )
    {
        //return $this->where('training_id', $training_id)->findAll();
        return $this->select('training_users.id, training_users.training_id, training_users.user_id, users.firstname, users.middlename, users.lastname')
                    ->join('users', 'users.id = training_users.user_id', 'left')  // LEFT JOIN to include users even if no match is found
                    ->where('training_users.training_id', $training_id)
                    ->findAll();
    }

    public function hasMembers( $training_id )
    {
        return $this->where('training_id', $training_id)->countAllResults() > 0;
    }

    public function countMembers( $training_id )
    {
        return $this->where('training_id', $training_id)->countAllResults();
    }
	
	public function findMemberTrainingId( $user_id )
	{
		$data = $this->where('user_id', $user_id)->first();
		
		if ( !is_null($data) )
			return (int) $data['training_id'];
		
		return NULL;
	}
}

