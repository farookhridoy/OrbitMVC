<?php

/**
 * Web Routes
 * All routes in this file are for web-based views.
 */

use OrbitMVC\Application;

$router = Application::instance()->getRouter();

$router->add('GET', '/', function() {
    return Application::instance()->view()->render('home', [
        'title' => 'Home',
        'username' => 'Expert User',
        'features' => [
            'Blade-like Template Engine',
            'Redis Registration Queue',
            'Atomic Search Caching',
            'State-less Architecture'
        ]
    ]);
});
