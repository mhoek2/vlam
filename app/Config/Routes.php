<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/',		'Front\Home::index', 			['filter' => \App\Filters\AuthFilterGuest::class]);
$routes->get('/home',	'Front\Home::application', 		['filter' => \App\Filters\AuthFilterUser::class]);

$routes->get('/admin',	'Admin\Home::dashboard', 	['filter' => \App\Filters\AuthFilterUser::class]);

$routes->get('meeting/(:any)',			'Front\Meeting::index/$1');

/**
 * admin
 */
$routes->get(	'/admin/meetings',				'Admin\MeetingsController::index', 			['filter' => \App\Filters\AuthFilterUser::class]);
$routes->post(	'/admin/meeting/(:any)/save',	'Admin\MeetingController::save/$1', 		['filter' => \App\Filters\AuthFilterUser::class]);
$routes->get(	'/admin/meeting/(:any)',		'Admin\MeetingController::index/$1', 		['filter' => \App\Filters\AuthFilterUser::class]);

$routes->post(	'admin/assignments/assignments_save_order', 	'Admin\AssignmentsController::save_order', 	['filter' => \App\Filters\AuthFilterUser::class]);

$routes->post(	'admin/assignments/(:any)/entries_save_order', 			'Admin\AssignmentController::entries_save_order/$1', 		['filter' => \App\Filters\AuthFilterUser::class]);
$routes->post(	'admin/assignments/(:any)/update_entry_name', 			'Admin\AssignmentController::update_entry_name', 			['filter' => \App\Filters\AuthFilterUser::class]);
$routes->post(	'admin/assignments/(:any)/update_entry_type', 			'Admin\AssignmentController::update_entry_type', 			['filter' => \App\Filters\AuthFilterUser::class]);
$routes->post(	'admin/assignments/(:any)/add_entry', 					'Admin\AssignmentController::add_entry/$1', 				['filter' => \App\Filters\AuthFilterUser::class]);
$routes->get(	'admin/assignments/(:any)/delete_property/(:any)', 		'Admin\AssignmentController::delete_property/$1/$2', 		['filter' => \App\Filters\AuthFilterUser::class]);
$routes->get(	'admin/assignments/(:any)/get_properties/(:any)', 		'Admin\AssignmentController::get_properties/$1/$2', 		['filter' => \App\Filters\AuthFilterUser::class]);
$routes->post(	'admin/assignments/(:any)/properties_save_order', 		'Admin\AssignmentController::properties_save_order/$1', 	['filter' => \App\Filters\AuthFilterUser::class]);
$routes->post(	'admin/assignments/(:any)/update_property', 			'Admin\AssignmentController::update_property/$1', 			['filter' => \App\Filters\AuthFilterUser::class]);
$routes->post(	'admin/assignments/(:any)/add_property', 				'Admin\AssignmentController::add_property', 				['filter' => \App\Filters\AuthFilterUser::class]);
$routes->get(	'admin/assignments/(:any)/', 							'Admin\AssignmentController::index/$1', 					['filter' => \App\Filters\AuthFilterUser::class]);	

service('auth')->routes($routes);
