<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 🔹 Public routes (no auth required)
$routes->get('/', 'Auth::login'); // Handled by filter to redirect if logged in
$routes->get('login', 'Auth::login');
$routes->post('auth/loginPost', 'Auth::loginPost');

// 🔹 Protected routes (auth filter required)
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Records page (root page when logged in)
    $routes->get('records', 'Employee::index');

    // Employee module
    $routes->get('employee', 'Employee::index');
    $routes->get('employee/create', 'Employee::create');
    $routes->post('employee/store', 'Employee::store');
    $routes->get('employee/edit/(:num)', 'Employee::edit/$1');
    $routes->post('employee/update/(:num)', 'Employee::update/$1');
    $routes->get('employee/delete/(:num)', 'Employee::delete/$1');
    $routes->get('employee/view/(:num)', 'Employee::view/$1');
    $routes->get('employee/directory', 'Employee::directory');
    $routes->get('employee/export',   'Employee::export');

    // Bulk import employees
    // Show the import form
    $routes->get('employee/import', 'Employee::importForm');

    // Process the uploaded file
    $routes->post('employee/import', 'Employee::import');


    // Location module
    $routes->get('locations/provinces', 'Location::getProvinces');
    $routes->get('locations/municipalities/(:num)', 'Location::getMunicipalities/$1');

    // QRRPA module
    $routes->get('qrrpa', 'QrrpaController::index');
    $routes->post('qrrpa/submit', 'QrrpaController::submit');
    $routes->get('qrrpa/summary', 'QrrpaController::summary');
    $routes->get('qrrpa/print', 'QrrpaController::print');
    $routes->post('qrrpa/result', 'QrrpaController::result');

    //$routes->get('/rpvara/progress/(:num)', 'Rpvara::progress/$1');
    $routes->post('/rpvara/update/(:num)', 'Rpvara::update/$1');
   // $routes->get('rpvara/progress', 'Rpvara::progress');

    // SMV
    $routes->get('/smv', 'Smv::index');
    $routes->post('/smv/update_status/(:num)', 'Smv::update_status/$1');
    $routes->get('smv/summary', 'Smv::summary');
    $routes->get('rpvara/progress', 'RpvaraController::progress');

    // $routes->get('rpvara/print_progress', 'Rpvara::printProgress');
    $routes->get('rpvara/print_progress', 'Smv::printProgress');


    // Logout
    $routes->get('logout', 'Auth::logout');
    
    $routes->get('rpvara/progress', 'Rpvara::progress');

});
