<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Front\Home::index', 			['filter' => \App\Filters\AuthFilterGuest::class]);

$routes->get('/home',									'Front\Home::application', 					['filter' => \App\Filters\AuthFilterSession::class]);
$routes->post('meeting/(:any)/assignment/(:any)/save',	'Front\AssignmentController::save/$1/$2',	['filter' => \App\Filters\AuthFilterSession::class]);
$routes->get('meeting/(:any)/assignment/(:any)',		'Front\AssignmentController::index/$1/$2',	['filter' => \App\Filters\AuthFilterSession::class]);
$routes->get('meeting/(:any)',							'Front\MeetingController::index/$1',		['filter' => \App\Filters\AuthFilterSession::class]);

/**
 * admin
 */
$routes->get(	'admin',												'Admin\Home::dashboard', 									['filter' => \App\Filters\AuthFilterAdmin::class]);


$routes->post(	'admin/trainings/add_training',							'Admin\TrainingsController::add_training', 					['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/trainings/delete_training',						'Admin\TrainingsController::delete_training', 				['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->get(	'admin/trainings',										'Admin\TrainingsController::index', 						['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/training/(:any)/save',							'Admin\TrainingController::save/$1', 						['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->get(	'admin/training/getUsersForAutocomplete',				'Admin\TrainingController::getUsersForAutocomplete', 		['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/training/(:any)/add_member',						'Admin\TrainingController::add_member/$1', 					['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/training/(:any)/delete_member', 					'Admin\TrainingController::delete_member/$1', 				['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->get(	'admin/training/(:any)',								'Admin\TrainingController::index/$1', 						['filter' => \App\Filters\AuthFilterAdmin::class]);

$routes->get(	'admin/meetings',										'Admin\MeetingsController::index', 							['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/meeting/(:any)/save',							'Admin\MeetingController::save/$1', 						['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->get(	'admin/meeting/(:any)',									'Admin\MeetingController::index/$1', 						['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/meeting/(:any)/add_assignment', 					'Admin\AssignmentsController::add_assignment', 				['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/meeting/(:any)/delete_assignment', 				'Admin\AssignmentsController::delete_assignment', 			['filter' => \App\Filters\AuthFilterAdmin::class]);

$routes->post(	'admin/assignments/(:any)/entries_save_order', 			'Admin\AssignmentController::entries_save_order/$1', 		['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/assignments/(:any)/update_entry_name', 			'Admin\AssignmentController::update_entry_name', 			['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/assignments/(:any)/update_entry_type', 			'Admin\AssignmentController::update_entry_type', 			['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/assignments/(:any)/add_entry', 					'Admin\AssignmentController::add_entry/$1', 				['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/assignments/(:any)/delete_entry', 				'Admin\AssignmentController::delete_entry/$1', 				['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->get(	'admin/assignments/(:any)/delete_property/(:any)', 		'Admin\AssignmentController::delete_property/$1/$2', 		['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->get(	'admin/assignments/(:any)/get_properties/(:any)', 		'Admin\AssignmentController::get_properties/$1/$2', 		['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/assignments/(:any)/properties_save_order', 		'Admin\AssignmentController::properties_save_order/$1', 	['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/assignments/(:any)/update_property', 			'Admin\AssignmentController::update_property/$1', 			['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/assignments/(:any)/add_property', 				'Admin\AssignmentController::add_property', 				['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->get(	'admin/assignments/(:any)/', 							'Admin\AssignmentController::index/$1', 					['filter' => \App\Filters\AuthFilterAdmin::class]);	
$routes->post(	'admin/assignments/(:any)/save',						'Admin\AssignmentController::save/$1', 						['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/assignments/assignments_save_order', 			'Admin\AssignmentsController::save_order', 					['filter' => \App\Filters\AuthFilterAdmin::class]);

service('auth')->routes($routes);
