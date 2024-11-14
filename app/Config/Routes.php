<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->get('/login', 'LoginController::login');

$routes->get('/investment', 'InvestmentController::index');

$routes->get('/register', 'LoginController::register');

$routes->get('/inicio', 'UserController::index');

$routes->get('/myprojects', 'ProjectController::list');

$routes->post('saveProject', 'ProjectController::saveProject');

$routes->get('/addProyect', 'ProjectController::addProyect');

/*Categoria */
$routes->get('categories', 'CategoryController::index');

$routes->get('categories/create', 'CategoryController::create');

$routes->post('categories/save', 'CategoryController::save');

$routes->get('categories/edit/(:num)', 'CategoryController::edit/$1');

$routes->post('categories/update/(:num)', 'CategoryController::update/$1');

$routes->get('categories/delete/(:num)', 'CategoryController::delete/$1');

/*Inversion */
$routes->get('investment/create', 'InvestmentController::create');

$routes->post('investment/save', 'InvestmentController::save');







