<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public routes
$routes->get('login',  'EmployeeController::login');
$routes->post('auth',  'EmployeeController::auth');
$routes->get('logout', 'EmployeeController::logout');

// Guarded routes (must be logged in)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/',                'EmployeeController::index');
    $routes->get('employee/create',  'EmployeeController::create');
    $routes->post('employee/insert', 'EmployeeController::insert');
});
