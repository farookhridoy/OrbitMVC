<?php

/**
 * API Routes
 * All routes in this file return JSON responses.
 */

use OrbitMVC\Application;
use App\Services\RegistrationService;
use App\Services\SearchService;
use OrbitMVC\Http\Request;

$router = Application::instance()->getRouter();

$router->add('POST', '/api/register', function() {
    $service = new RegistrationService();
    $data = (new Request())->input();
    
    if ($service->register($data)) {
        return ["status" => "accepted", "message" => "Registration queued successfully."];
    }
    
    return ["status" => "error", "message" => "Critical failure."];
});

$router->add('GET', '/api/search', function() {
    $query = (new Request())->input('q') ?? '';
    $service = new SearchService();
    
    return [
        "query" => $query,
        "results" => $service->search($query),
        "source" => "Redis Cache (Optimized)"
    ];
});
