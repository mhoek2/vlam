<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('meeting/(:any)', 'Meeting::index/$1');

service('auth')->routes($routes);
