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
$routes->get('customer/dashboard', 'Auth::customerDashboard');
$routes->post('customer/profile', 'Auth::updateCustomerProfile');
$routes->post('customer/bookings', 'Auth::createBooking');
$routes->post('customer/support', 'Auth::createSupportRequest');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerProcess');
$routes->get('logout', 'Auth::logout');
$routes->get('admin/login', 'Auth::adminLogin');
$routes->post('admin/login', 'Auth::adminLoginProcess');
$routes->get('admin/dashboard', 'Auth::employeeDashboard');
$routes->post('admin/staff/create', 'Auth::createStaffAccount');
$routes->post('admin/time-in', 'Auth::timeIn');
$routes->post('admin/time-out', 'Auth::timeOut');
$routes->post('admin/announcements', 'Auth::createAnnouncement');
$routes->post('admin/services', 'Auth::saveServiceSetting');
$routes->post('admin/reports', 'Auth::createServiceReport');
$routes->post('admin/bookings/(:num)', 'Auth::updateBooking/$1');
$routes->post('admin/staff/(:num)/deactivate', 'Auth::deactivateStaff/$1');
$routes->get('admin/departments', 'Auth::adminDepartments');
$routes->get('admin/logout', 'Auth::adminLogout');
