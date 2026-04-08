<?php

require_once __DIR__ . '/../vendor/autoload.php';

use OrbitMVC\Application;
use App\Services\RegistrationService;
use App\Services\SearchService;

$app = new Application();
$router = $app->getRouter();

// 1. Home Route: Demonstrating View Engine (Blade-like)
$router->add('GET', '/', function() {
    return \OrbitMVC\Application::instance()->view()->render('home', [
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

// 2. Registration Route: Demonstrating Async Queue (70k user scale)
$router->add('POST', '/api/register', function() {
    $service = new RegistrationService();
    $data = (new \OrbitMVC\Http\Request())->input();
    
    if ($service->register($data)) {
        return ["status" => "accepted", "message" => "Registration queued successfully."];
    }
    
    return ["status" => "error", "message" => "Critical failure."];
});

// 3. Search Route: Demonstrating High-Speed Cache (70k user scale)
$router->add('GET', '/api/search', function() {
    $query = (new \OrbitMVC\Http\Request())->input('q') ?? '';
    $service = new SearchService();
    
    return [
        "query" => $query,
        "results" => $service->search($query),
        "source" => "Redis Cache (Optimized)"
    ];
});

$app->run();
