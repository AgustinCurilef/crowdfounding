<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/* Solo acceden los admins */
$routes->group('', ['filter' => ['login', 'role:1']], function ($routes) {
    /*Categoria */
    $routes->get('categories', 'CategoryController::index');

    $routes->get('categories/create', 'CategoryController::create');

    $routes->post('categories/save', 'CategoryController::save');

    $routes->get('categories/edit/(:num)', 'CategoryController::edit/$1');

    $routes->post('categories/update/(:num)', 'CategoryController::update/$1');

    $routes->get('categories/delete/(:num)', 'CategoryController::delete/$1');

    /*Notificaciones*/

    $routes->get('notification', 'NotificationController::index');

    $routes->get('notification/create', 'NotificationController::create');

    $routes->post('notification/save', 'NotificationController::save');

    $routes->get('notification/edit/(:num)', 'NotificationController::edit/$1');

    $routes->post('notification/update/(:num)', 'NotificationController::update/$1');

    $routes->get('notification/delete/(:num)', 'NotificationController::delete/$1');

    /*Proyectos*/

    $routes->post('project/toggle-visibility-explorer/(:num)', 'ProjectController::toggleVisibilityExplorer/$1');
});

/* Solo acceden los usuarios comunes */
$routes->group('', ['filter' => 'login'], function ($routes) {
    /*Usuarios */

    $routes->get('/inicio', 'ProjectController::listAllProjects');

    $routes->get('/editProfile', 'UserController::editProfile');

    $routes->get('/user/showImage/(:num)', 'UserController::showImage/$1');

    $routes->post('user/saveChanges', 'UserController::saveChanges');

    $routes->post('/user/delete/(:num)', 'UserController::delete/$1');

    $routes->get('/profile/(:segment)', 'UserController::scoreEntrepreneur/$1');

    $routes->post('/rating/submit', 'UserController::submitRating');

    /*Proyectos */

    $routes->get('/myprojects', 'ProjectController::list');

    $routes->post('saveProject', 'ProjectController::saveProject');

    $routes->get('/addProyect', 'ProjectController::addProyect');

    $routes->get('/modifyProject/(:num)', 'ProjectController::modify/$1');

    $routes->post('/updateProject/(:num)', 'ProjectController::updateProject/$1');

    $routes->get('/deleteProject/(:num)', 'ProjectController::deleteProject/$1');



    $routes->get('project/details/(:num)', 'ProjectController::details/$1');
    $routes->get('project/showFrontUpdates/(:num)/(:num)/(:any)', 'ProjectController::showFrontUpdates/$1/$2/$3');

    $routes->get('shareUpdateProject/(:num)', 'ProjectController::shareUpdateProject/$1');

    $routes->post('saveUpdateProject/(:num)', 'ProjectController::saveUpdateProject/$1');

    $routes->post('project/toggle-visibility/(:num)', 'ProjectController::toggleVisibility/$1');

    /*Inversion */
    $routes->get('investment/create/(:num)', 'InvestmentController::create/$1');

    $routes->post('investment/save', 'InvestmentController::save');

    $routes->get('/myInvestments', 'ProjectController::listInvestments');



    $routes->post('notification/mark-read', 'NotificationUserController::markAllAsRead');


    /*Notificaciones Usuario*/

    $routes->group('user/notifications', ['namespace' => 'App\Controllers'], function ($routes) {
        $routes->get('/', 'NotificationUserController::index');
        $routes->get('unread-count', 'NotificationUserController::getUnreadCount');
        $routes->get('recent', 'NotificationUserController::recent');
        $routes->post('mark-read/(:num)', 'NotificationUserController::markAsRead/$1');
    });
});




/*Ambos pueden acceder */
$routes->get('/', 'HomeController::index');

$routes->get('/login', 'LoginController::login');

$routes->get('/logout', 'LoginController::logout');

$routes->get('/register', 'registerController::register');

$routes->post('/login/authenticate', 'LoginController::authenticate');

$routes->get('/unauthorized', 'LoginController::unauthorized');

$routes->get('/project/showFront/(:num)', 'ProjectController::showFront/$1');

/*Registro*/

$routes->post('/register', 'registerController::store');
