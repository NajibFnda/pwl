<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Ubah ke Controller yang kita buat tadi:
$routes->get('/', 'BreachChecker::index');
$routes->post('/check', 'BreachChecker::checkEmail');