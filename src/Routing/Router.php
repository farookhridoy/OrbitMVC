<?php

namespace OrbitMVC\Routing;

use OrbitMVC\Http\Request;

class Router {
    protected array $routes = [];
    protected array $globalMiddleware = [];

    public function add(string $method, string $uri, $action, array $middleware = []) {
        $this->routes[$method][$uri] = [
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public function dispatch(Request $request) {
        $method = $request->method();
        $uri = $request->uri();

        if (isset($this->routes[$method][$uri])) {
            $route = $this->routes[$method][$uri];
            
            // Execute Middleware
            foreach ($route['middleware'] as $middleware) {
                if (class_exists($middleware)) {
                    $instance = new $middleware();
                    $instance->handle();
                }
            }

            return $this->callAction($route['action']);
        }

        // Simple fallback for demonstration
        http_response_code(404);
        return json_encode(["error" => "Route $uri not found"]);
    }

    protected function callAction($action) {
        if (is_callable($action)) {
            return $action();
        }

        if (is_string($action)) {
            [$controller, $method] = explode('@', $action);
            $controllerClass = "App\\Controllers\\$controller";
            
            if (class_exists($controllerClass)) {
                $instance = new $controllerClass();
                return $instance->$method();
            }
        }
        
        throw new \Exception("Action could not be resolved.");
    }
}
