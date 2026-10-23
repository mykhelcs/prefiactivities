<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'EmployeeController::index');
$routes->get('employee/create', 'EmployeeController::create');
$routes->post('employee/insert', 'EmployeeController::insert');
$routes->get('login', 'EmployeeController::login');
$routes->post('auth', 'EmployeeController::auth');
$routes->get('logout', 'EmployeeController::logout');
