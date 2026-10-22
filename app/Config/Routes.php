<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages::home');
$routes->get('details', 'Pages::details');
$routes->get('agent', 'Pages::agent');
$routes->get('about', 'Pages::about');
$routes->get('social/(:segment)', 'Pages::social/$1');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginProcess');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerProcess');
$routes->get('logout', 'Auth::logout');
$routes->get('admin/login', 'Auth::adminLogin');
$routes->post('admin/login', 'Auth::adminLoginProcess');
$routes->get('admin/dashboard', 'Auth::employeeDashboard');
$routes->post('admin/time-in', 'Auth::timeIn');
$routes->post('admin/time-out', 'Auth::timeOut');
$routes->get('admin/departments', 'Auth::adminDepartments');
$routes->get('admin/logout', 'Auth::adminLogout');
