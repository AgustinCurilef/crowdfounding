<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->get('/login', 'LoginController::login');

$routes->get('/register', 'LoginController::register');

$routes->get('/inicio', 'UserController::index');

$routes->get('/myprojects', 'ProjectController::list');

$routes->post('saveProject', 'ProjectController::saveProject');

$routes->get('/addProyect', 'ProjectController::addProyect');






