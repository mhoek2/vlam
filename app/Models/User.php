<?php

namespace App\Models;

use CodeIgniter\Model;

use App\Models\TrainingUsers;

class User extends Model
{
    private static function generateShortName( $user ) {
        $first_name = $user['firstname'] ?? '';
        $last_name = $user['lastname'] ?? '';

        return strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1));
    }

    public function getUserInfo() {
        $user = auth()->user();

        if($user == NULL)
            return false;

        $data = $user->toRawArray();
        $data["shortname"] = $this->generateShortName( $data );

        $data["is_admin"] = $this->isAdmin();
		
		$data["training_id"] = (new TrainingUsers())->findMemberTrainingId( $data['id'] );

		if ( $data["is_admin"] )
			$data["training_id"] = NULL;	// admins view the 'non cloned' version of assignments and cases
		
		//$data["training_id"] = NULL;
		
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

