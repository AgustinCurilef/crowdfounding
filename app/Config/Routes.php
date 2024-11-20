<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->get('/login', 'LoginController::login');

$routes->get('/register', 'registerController::register');

$routes->post('/login/authenticate', 'LoginController::authenticate');

/*Usuarios */

$routes->get('/inicio', 'ProjectController::listAllProjects');

$routes->get('/editProfile', 'UserController::editProfile');

$routes->get('/user/showImage/(:num)', 'UserController::showImage/$1');

$routes->post('user/saveChanges', 'UserController::saveChanges');

/*Proyectos */

$routes->get('/myprojects', 'ProjectController::list');

$routes->post('saveProject', 'ProjectController::saveProject');

$routes->get('/addProyect', 'ProjectController::addProyect');

$routes->get('/modifyProject/(:num)', 'ProjectController::modify/$1');

$routes->post('/updateProject/(:num)', 'ProjectController::updateProject/$1');

$routes->get('/deleteProject/(:num)', 'ProjectController::deleteProject/$1');






/*Categoria */
$routes->get('categories', 'CategoryController::index');

$routes->get('categories/create', 'CategoryController::create');

$routes->post('categories/save', 'CategoryController::save');

$routes->get('categories/edit/(:num)', 'CategoryController::edit/$1');

$routes->post('categories/update/(:num)', 'CategoryController::update/$1');

$routes->get('categories/delete/(:num)', 'CategoryController::delete/$1');

/*Inversion */
$routes->get('investment/create/(:num)', 'InvestmentController::create/$1');

$routes->post('investment/save', 'InvestmentController::save');

$routes->get('/myInvestments', 'ProjectController::listInvestments');


$routes->post('/register', 'registerController::store');
