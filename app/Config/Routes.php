<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/**
 * front
 */

$routes->get(	'login', 		'LoginController::loginView');
$routes->post(	'login', 		'LoginController::loginAction');

$routes->get(	'/', 		'Front\Home::index', 							['filter' => \App\Filters\AuthFilterGuest::class]);
$routes->get(	'/home',	'Front\Home::application', 						['as' => 'home', 'filter' => \App\Filters\AuthFilterSession::class]);
$routes->get(	'download/(:any)',	'DownloadController::index/$1', 		['as' => 'front.download', 'namespace' => 'App\Controllers\Front', 'filter' => \App\Filters\AuthFilterSession::class]);

// Meeting
$routes->group('meeting/(:num)', ['namespace' => 'App\Controllers\Front', 'filter' => \App\Filters\AuthFilterSession::class], function ($routes) 
{
	$routes->get(	'',	'MeetingController::index/$1', 													['as' => 'front.meeting']);
	
	// Files
	$routes->group('files/', function ($routes)
	{
		$routes->get(	'',							'FilesController::index/$1', 						['as' => 'front.files']);
		$routes->post(	'upload', 					'FilesController::upload/$1', 						['as' => 'front.files_upload']);
		$routes->post(	'delete_file', 				'FilesController::delete_file/$1', 					['as' => 'front.files_delete']);
	});
	
	// Assignment
	$routes->group('assignment/(:num)', function ($routes)
	{
		$routes->get(	'',		'AssignmentController::index/$1/$2',									['as' => 'front.assignment']);
		
		$routes->post(	'save',	'AssignmentController::save/$1/$2');
		$routes->get(	'sub',	'AssignmentController::index/$1/$2/true');
		
		// Case
		$routes->group('case/(:num)', function ($routes)
		{
			$routes->post(	'(:num)/save',	'CaseController::save/$1/$2/$3/$4');
			$routes->get(	'(:num)',		'CaseController::entry/$1/$2/$3/$4', 						['as' => 'front.case.entry']);
			$routes->get(	'end',			'CaseController::outro/$1/$2/$3/$4', 						['as' => 'front.case.end']);
			$routes->get(	'complete',		'CaseController::complete/$1/$2/$3', 						['as' => 'front.case.complete']);
			$routes->get(	'',				'CaseController::index/$1/$2/$3', 							['as' => 'front.case']);	
		});
	});
});

/**
 * admin
 */
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => \App\Filters\AuthFilterAdmin::class], function ($routes) 
{
	$routes->get(	'',								'Home::dashboard', 									['as' => 'admin']);
	
	// Training
	$routes->post(	'trainings/add_training',		'TrainingsController::add_training');
	$routes->post(	'trainings/delete_training',	'TrainingsController::delete_training');
	$routes->get(	'trainings',					'TrainingsController::index', 						['as' => 'admin.trainings']);
	
	$routes->group('training/(:num)', function ($routes)
	{
		$routes->get(	'',							'TrainingController::index/$1', 					['as' => 'admin.training']);
		$routes->post(	'save',						'TrainingController::save/$1',						['as' => 'admin.training.save']);
		$routes->post(	'start',					'TrainingController::start/$1',						['as' => 'admin.training.start']);
		$routes->post(	'stop',						'TrainingController::stop/$1',						['as' => 'admin.training.stop']);
		$routes->post(	'force_reset',				'TrainingController::force_reset/$1',				['as' => 'admin.training.force_reset']);
		$routes->post(	'add_member',				'TrainingController::add_member/$1');
		$routes->post(	'delete_member', 			'TrainingController::delete_member/$1');
	});
	$routes->get(	'training/getUsersForAutocomplete',	'TrainingController::getUsersForAutocomplete', 	['as' => 'admin.find_user_autocomplete']);
	
	// Meeting
	$routes->get(	'meetings',						'MeetingsController::index', 						['as' => 'admin.meetings']);
	
	$routes->group('meeting/(:num)', function ($routes)
	{
		$routes->get(	'',							'MeetingController::index/$1', 						['as' => 'admin.meeting']);
		$routes->post(	'save',						'MeetingController::save/$1', 						['as' => 'admin.meeting.save']);
		$routes->post(	'add_assignment', 			'AssignmentsController::add_assignment');
		$routes->post(	'delete_assignment', 		'AssignmentsController::delete_assignment');
	});
	
	// Assignment
	$routes->post(	'assignments/assignments_save_order', 'AssignmentsController::save_order', 			['as' => 'admin.assignments.save_order']);
	
	$routes->group('assignments/(:num)', function ($routes)
	{
		$routes->post(	'entries_save_order', 		'AssignmentController::entries_save_order/$1');
		$routes->post(	'update_entry_name', 		'AssignmentController::update_entry_name');
		$routes->post(	'update_entry_optional', 	'AssignmentController::update_entry_optional');
		$routes->post(	'update_entry_type', 		'AssignmentController::update_entry_type');
		$routes->post(	'add_entry', 				'AssignmentController::add_entry/$1');
		$routes->post(	'delete_entry', 			'AssignmentController::delete_entry/$1');
		$routes->post(	'delete_property/(:num)', 	'AssignmentController::delete_property/$1/$2');
		$routes->get(	'get_properties/(:num)', 	'AssignmentController::get_properties/$1/$2');
		$routes->post(	'properties_save_order', 	'AssignmentController::properties_save_order/$1');
		$routes->post(	'update_property', 			'AssignmentController::update_property/$1');
		$routes->post(	'add_property', 			'AssignmentController::add_property');
		$routes->post(	'save',						'AssignmentController::save/$1', 					['as' => 'admin.assignment.save']);
		$routes->post(	'add_case', 				'CasesController::add_case');
		$routes->post(	'delete_case', 				'CasesController::delete_case');
		$routes->get(	'', 						'AssignmentController::index/$1', 					['as' => 'admin.assignment']);	
	});
	
	// Case
	$routes->post(	'cases/cases_save_order',  'CasesController::save_order', 							['as' => 'admin.cases.save_order']);
	
	$routes->group('cases/(:num)', function ($routes)
	{
		$routes->post(	'entries_save_order', 		'CaseController::entries_save_order/$1');
		$routes->post(	'update_entry_name', 		'CaseController::update_entry_name');
		$routes->post(	'update_entry_optional', 	'CaseController::update_entry_optional');
		$routes->post(	'update_entry_type', 		'CaseController::update_entry_type');
		$routes->post(	'add_entry', 				'CaseController::add_entry/$1');
		$routes->post(	'delete_entry', 			'CaseController::delete_entry/$1');
		$routes->post(	'delete_property/(:num)', 	'CaseController::delete_property/$1/$2');
		$routes->get(	'get_properties/(:num)', 	'CaseController::get_properties/$1/$2');
		$routes->post(	'properties_save_order', 	'CaseController::properties_save_order/$1');
		$routes->post(	'update_property', 			'CaseController::update_property/$1');
		$routes->post(	'add_property', 			'CaseController::add_property');
		$routes->post(	'save',						'CaseController::save/$1', 							['as' => 'admin.case.save']);
		$routes->get(	'', 						'CaseController::index/$1', 						['as' => 'admin.case']);	
	});
	
	// User
	$routes->get(	'users/new', 					'UserController::new_user', 						['as' => 'admin.user.new']);
	$routes->post(	'users/new', 					'UserController::new_user_create');
	$routes->get(	'users',						'UsersController::index', 							['as' => 'admin.users']);
	
	$routes->group('users/(:num)', function ($routes)
	{
		$routes->get(	'', 						'UserController::index/$1', 						['as' => 'admin.user']);
		$routes->post(	'', 						'UserController::update/$1', 						['as' => 'admin.user.update']);
		$routes->post(	'delete', 					'UserController::delete/$1', 						['as' => 'admin.user.delete']);
		$routes->post(	'change_password', 			'UserController::change_password/$1', 				['as' => 'admin.user.change_password']);

		$routes->get(	'insight', 					'UserInsightController::index/$1', 					['as' => 'admin.user.insight']);
		$routes->post(	'insight_result', 			'UserInsightController::get_result/$1', 			['as' => 'admin.user.insight_result']);
		
	});
	
	// Files
	$routes->group('files/', function ($routes)
	{
		$routes->get(	'', 						'FilesController::index', 							['as' => 'admin.files']);
		$routes->post(	'upload', 					'FilesController::upload', 							['as' => 'admin.files_upload']);
		$routes->post(	'delete_file', 				'FilesController::delete_file', 					['as' => 'admin.files_delete']);
	});
});

service('auth')->routes($routes);
