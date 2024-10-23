<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Route Asli CI
// $routes->get('/', 'Home::index');
$routes->get('/', 'App\Home::index');

// Application route
$routes->group('app', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'App\Home::index');   
    $routes->get('home', 'App\Home::home');   
    $routes->get('city', 'App\City::index');
    $routes->get('city/form', 'App\City::form');
    $routes->post('city/submit', 'App\City::submit');
    $routes->get('city/edit/(:num)', 'App\city::edit/$1');
    $routes->post('city/delete/(:num)', 'App\city::delete/$1');
    $routes->get('province', 'App\Province::index');
    $routes->get('province/form', 'App\Province::form');
    $routes->get('province/edit/(:num)', 'App\Province::edit/$1');
    $routes->post('province/delete/(:num)', 'App\Province::delete/$1');
    $routes->post('province/submit', 'App\Province::submit');
    $routes->get('indicator', 'App\Indicator::index');
    $routes->get('indicator/form', 'App\Indicator::form');
    $routes->get('indicator/edit/(:num)', 'App\Indicator::edit/$1');
    // $routes->get('indicator/getCityByProvince/(:num)', 'App\Indicator::getCityByProvince/$1');
    // $routes->get('indicator/getTransactionByCity/', 'App\Indicator::getTransactionByCity');
    $routes->get('/app/transaction', 'App\Transaction::index'); // Route for listing transactions
    // $routes->post('/app/transaction/selectCity', 'App\Transaction::selectCity'); 
    $routes->get('/app/transaction/form', 'App\Transaction::form'); 
    // $routes->post('/app/transaction/form', 'App\Transaction::submit'); 
    $routes->get('/app/transaction/edit/(:num)', 'App\Transaction::edit/$1'); 
    $routes->post('/app/transaction/delete/(:num)', 'App\Transaction::delete/$1'); 
    $routes->post('indicator/selectProvince/', 'App\Indicator::selectProvince');
    $routes->post('indicator/selectCity/', 'App\Indicator::selectCity');
    $routes->post('indicator/delete/(:num)', 'App\Indicator::delete/$1');
    $routes->post('indicator/submit', 'App\Indicator::submit');
    $routes->get('admin/users', 'Admin\Users::index');
    $routes->get('domain1', 'App\Domain1::index');
    $routes->get('domain1/form', 'App\domain1::form');
    $routes->get('domain1/edit/(:num)', 'App\domain1::edit/$1');
    $routes->post('domain1/delete/(:num)', 'App\domain1::delete/$1');
    $routes->post('domain1/submit', 'App\domain1::submit');
    $routes->get('domain2', 'App\Domain2::index');
    $routes->get('domain2/form', 'App\domain2::form');
    $routes->get('domain2/edit/(:num)', 'App\domain2::edit/$1');
    $routes->post('domain2/delete/(:num)', 'App\domain2::delete/$1');
    $routes->post('domain2/submit', 'App\domain2::submit');
    $routes->get('domain3', 'App\Domain3::index');
    $routes->get('domain3/form', 'App\domain3::form');
    $routes->get('domain3/edit/(:num)', 'App\domain3::edit/$1');
    $routes->post('domain3/delete/(:num)', 'App\domain3::delete/$1');
    $routes->post('domain3/submit', 'App\domain3::submit');  
    $routes->get('profile', 'App\Profile::index');
    $routes->post('profile/update', 'App\Profile::update');
});
// $routes->group('admin', ['filter' => 'auth'], function($routes){
//     $routes->get('users', 'Admin\Users::index');
// });

// Auth route
$routes->group('auth', function($routes) {
    $routes->get('/', 'Auth::index');
    $routes->get('login', 'Auth::login');
    $routes->post('validate', 'Auth::do_validate');
    $routes->get('logout', 'Auth::logout');   
});
// Admin Route
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/submit', 'Admin\Users::submit');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');
    $routes->post('users/delete/(:num)', 'Admin\Users::delete/$1');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
});

// DbTest
$routes->get('db-test', 'DbTest::index');
$routes->get('phpinfo', 'Home::phpinfo');