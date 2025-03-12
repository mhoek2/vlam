<?php

namespace App\Models;

use CodeIgniter\Model;

use App\Models\TrainingUsers;

class User extends Model
{
    public function getUserInfo() {
        $user = auth()->user();

        if($user == NULL)
            return false;

        $data = $user->toRawArray();
        $data["shortname"] = generateUserShortName( $data );
        $data["fullname"] = generateUserFullName( $data );

        $data["is_admin"] = $this->isAdmin();
		
		$data["training_id"] = (new TrainingUsers())->findMemberTrainingId( $data['id'] );

        // Admins always view the Leading Training.
        // Commenting next statement will assign admin to the training it is assigned to. (simulating a end-user role)
		if ( $data["is_admin"] )
			$data["training_id"] = NULL;
		
        return($data);
    }
	
    public function isLoggedIn()
    {
        $user = auth()->user();

        if($user == NULL)
            return false;

        // Check if user is logged in by verifying session data
        if (session()->has('user_id'))
            return false;

        return true;
    }

    public function isAdmin()
    {
        if (!$this->isLoggedIn())
            return false;

        if (!auth()->user()->inGroup('admin'))
            return false;

        return true;
    }
}

