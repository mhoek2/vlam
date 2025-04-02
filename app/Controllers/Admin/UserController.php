<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use CodeIgniter\Validation\Validation;
use CodeIgniter\I18n\Time;

use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Traits\Viewable;
use CodeIgniter\Shield\Validation\ValidationRules;

use App\Models\Users;

class UserController extends BaseController
{
	protected $userModel;
	
    public function __construct() {
		$this->userModel = new Users();
    }

	public function new_user () : string 
	{
		load_header( $this->data );
		load_footer( $this->data );
		
        return view('admin/user', $this->data);
	}
	
    /**
     * Create new user
     *
	 * function borrowed from:
     * 'vendor/codeigniter4/shield/src/Con trollers/RegisterController->registerAction()'
     */
	public function new_user_create() 
	{
		helper(['form']);

		$users = $this->getUserProvider();
		$rules = $this->getValidationRules();
		
        $additionalRules = [
            'firstname' => 'required|min_length[2]',
            'lastname' => 'required|min_length[2]',
        ];
		
        $additionalData = [
            'firstname' => $this->request->getPost('firstname'),
            'middlename' => $this->request->getPost('middlename'),
            'lastname' => $this->request->getPost('lastname'),
        ];
		
		
		$rules = array_merge($rules, $additionalRules);

		// Validation failed
	    if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
		
        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $users->createNewUser($this->request->getPost($allowedPostFields));

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Add to default group
        $users->addToDefaultGroup($user);
		
		// Update additional fields manually
		// .. Could extend shields UserModel
		$db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id', $user->id)->update($additionalData);
	
		$post = $this->request->getPost();

		return redirect()->to(route_to('admin.user', $user->id));
	}
	
	public function update( int $user_id ) {
		helper(['form']);
		
        $validation = \Config\Services::validation();
		
        $data = [
            'firstname' => $this->request->getPost('firstname'),
            'middlename' => $this->request->getPost('middlename'),
            'lastname' => $this->request->getPost('lastname'),
        ];
		
        $rules = [
            'firstname' => 'required|min_length[2]',
            'lastname' => 'required|min_length[2]',
        ];

		// Validation failed
		if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {	
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		} 
		
		$db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id', $user_id)->update($data);
		
		return redirect()->to(route_to('admin.user', $user_id));
	}

	public function delete( int $user_id )
	{
		$user = auth()->user(); // current user

		return redirect()->back()->with('error', 'You cannot delete your own account.');
		
		if ($user->id === $user_id) {
			return redirect()->back()->with('error', 'You cannot delete your own account.');
		}
		
		$users = auth()->getProvider();

		if ($users->delete($user_id, true))
			return redirect()->to(route_to('admin.users'));
		else
			return redirect()->back()->with('error', 'Something went wrong deleting this account!.');
	}
	
	public function change_password( int $user_id )
	{
		helper(['form']);
		$passwords = service('passwords');
		
		$users = $this->getUserProvider();
		$allRules = $this->getValidationRules();
		
		$rules = [
			"password" 			=> $allRules['password'],
			"password_confirm" 	=> $allRules['password_confirm']
		];

		
	    if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
			return $this->response->setJSON([
				'status' 			=> 'error',
				'errors'			=> $this->validator->getErrors(),
				'new_csrf_token' 	=> csrf_hash(),
			]);
        }
		
		$user = $users->findById($user_id);
		$user->fill([
			'password' => $this->request->getPost('password')
		]);
		$users->save($user);	
		
		return $this->response->setJSON([
			'status' 			=> 'success', 
			'message'			=> 'Wachtwoord is gewijzigd!', 
			'new_csrf_token' 	=> csrf_hash(),
		]);
	}
	
    public function index( int $user_id ): string
    {
		// User
		$selected_user = $this->userModel->getUser( $user_id );
		
		if ( empty($selected_user) && isset($selected_user[0]) )
			die('invalid user!');
		
		$this->data['selected_user'] = $selected_user[0];
		
		load_header( $this->data );
		load_footer( $this->data );
		
        return view('admin/user', $this->data);
    }
	
    /**
     * Returns the User provider
     */
    protected function getUserProvider(): UserModel
    {
        $provider = model(setting('Auth.userProvider'));

        assert($provider instanceof UserModel, 'Config Auth.userProvider is not a valid UserProvider.');

        return $provider;
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, list<string>|string>>
     */
    protected function getValidationRules(): array
    {
        $rules = new ValidationRules();

        return $rules->getRegistrationRules();
    }		
}