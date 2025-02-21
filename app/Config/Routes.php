<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get(	'/', 		'Front\Home::index', 			['filter' => \App\Filters\AuthFilterGuest::class]);
$routes->get(	'/home',	'Front\Home::application', 		['filter' => \App\Filters\AuthFilterSession::class]);

$routes->post(	'meeting/(:num)/assignment/(:num)/case/(:num)/(:num)/save',	'Front\CaseController::save/$1/$2/$3/$4',				['filter' => \App\Filters\AuthFilterSession::class]);
$routes->get(	'meeting/(:num)/assignment/(:num)/case/(:num)/(:num)',		'Front\CaseController::entry/$1/$2/$3/$4',				['filter' => \App\Filters\AuthFilterSession::class]);
$routes->get(	'meeting/(:num)/assignment/(:num)/case/(:num)/end',			'Front\CaseController::outro/$1/$2/$3/$4',				['filter' => \App\Filters\AuthFilterSession::class]);
$routes->get(	'meeting/(:num)/assignment/(:num)/case/(:num)',				'Front\CaseController::index/$1/$2/$3',					['filter' => \App\Filters\AuthFilterSession::class]);

$routes->post(	'meeting/(:num)/assignment/(:num)/save',					'Front\AssignmentController::save/$1/$2',				['filter' => \App\Filters\AuthFilterSession::class]);
$routes->get(	'meeting/(:num)/assignment/(:num)',							'Front\AssignmentController::index/$1/$2',				['filter' => \App\Filters\AuthFilterSession::class]);
$routes->get(	'meeting/(:num)',											'Front\MeetingController::index/$1',					['filter' => \App\Filters\AuthFilterSession::class]);

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
$routes->post(	'admin/assignments/(:any)/add_case', 					'Admin\CasesController::add_case', 							['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/assignments/(:any)/delete_case', 				'Admin\CasesController::delete_case', 						['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/assignments/assignments_save_order', 			'Admin\AssignmentsController::save_order', 					['filter' => \App\Filters\AuthFilterAdmin::class]);


$routes->post(	'admin/cases/(:any)/entries_save_order', 				'Admin\CaseController::entries_save_order/$1', 				['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/cases/(:any)/update_entry_name', 				'Admin\CaseController::update_entry_name', 					['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/cases/(:any)/update_entry_type', 				'Admin\CaseController::update_entry_type', 					['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/cases/(:any)/add_entry', 						'Admin\CaseController::add_entry/$1', 						['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/cases/(:any)/delete_entry', 						'Admin\CaseController::delete_entry/$1', 					['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->get(	'admin/cases/(:any)/delete_property/(:any)', 			'Admin\CaseController::delete_property/$1/$2', 				['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->get(	'admin/cases/(:any)/get_properties/(:any)', 			'Admin\CaseController::get_properties/$1/$2', 				['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/cases/(:any)/properties_save_order', 			'Admin\CaseController::properties_save_order/$1', 			['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/cases/(:any)/update_property', 					'Admin\CaseController::update_property/$1', 				['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/cases/(:any)/add_property', 						'Admin\CaseController::add_property', 						['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->get(	'admin/cases/(:any)/', 									'Admin\CaseController::index/$1', 							['filter' => \App\Filters\AuthFilterAdmin::class]);	
$routes->post(	'admin/cases/(:any)/save',								'Admin\CaseController::save/$1', 							['filter' => \App\Filters\AuthFilterAdmin::class]);
$routes->post(	'admin/cases/cases_save_order', 						'Admin\CasesController::save_order', 						['filter' => \App\Filters\AuthFilterAdmin::class]);


service('auth')->routes($routes);
