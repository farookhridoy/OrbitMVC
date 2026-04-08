<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use OrbitMVC\Routing\Router;
use OrbitMVC\Http\Request;

class RouterTest extends TestCase {
    public function test_router_can_register_and_dispatch_routes() {
        $router = new Router();
        
        $router->add('GET', '/test', function() {
            return "success";
        });

        // Mock a request
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/test';
        
        $request = new Request();
        $response = $router->dispatch($request);
        
        $this->assertEquals("success", $response);
    }

    public function test_router_returns_404_for_unknown_routes() {
        $router = new Router();
        
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/unknown';
        
        $request = new Request();
        $response = $router->dispatch($request);
        
        $data = json_decode($response, true);
        $this->assertArrayHasKey('error', $data);
    }
}
