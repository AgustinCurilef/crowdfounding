<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->get('/login', 'LoginController::login');

$routes->get('/register', 'registerController::register');

$routes->get('/inicio', 'UserController::index');

$routes->get('/myprojects', 'ProjectController::list');

$routes->post('/register', 'registerController::store');





