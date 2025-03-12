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
        $builder = $this->select('training_users.id, training_users.training_id, training_users.user_id, users.username, users.firstname, users.middlename, users.lastname, auth_groups_users.group, auth_identities.secret as email')
                    ->join('users', 'users.id = training_users.user_id', 'left')
					->join('auth_identities', 'auth_identities.user_id = training_users.user_id', 'left')
					->join('auth_groups_users', 'auth_groups_users.user_id = training_users.user_id', 'left')
                    ->where('training_users.training_id', $training_id);

		$items = $builder->findAll();
		
		foreach( $items as $id => $item ) {
			$items[$id]['shortname'] = generateUserShortName( $item );
			$items[$id]['fullname'] = generateUserFullName( $item );
		}
		
		return $items;
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

