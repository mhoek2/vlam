<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['firstname', 'middlename', 'lastname'];

	// TODO:
	//
	// cleaner to use find, findall overrides for getUser and getUsers?

    public function getUser( $user_id = NULL  )
    {
		return $this->getUsers( $user_id );
    }
	
    public function getUsers( $user_id = NULL )
    {
		$builder = $this->select('users.id, users.firstname, users.middlename, users.lastname, training_users.training_id, trainings.name as training_name, auth_groups_users.group')
					->join('training_users', 'training_users.user_id = users.id', 'left')  // LEFT JOIN for training info
					->join('trainings', 'trainings.id = training_users.training_id', 'left')  // LEFT JOIN for training info
					->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left');  // LEFT JOIN for user group info
					
		if ( !empty($user_id) && is_int($user_id ) )
			$builder->where('users.id', $user_id);
		
		$items = $builder->findAll();

		foreach( $items as $id => $item ) {
			$items[$id]['shortname'] = generateUserShortName( $item );
			$items[$id]['fullname'] = generateUserFullName( $item );
		}
		
		return $items;
    }	
}

