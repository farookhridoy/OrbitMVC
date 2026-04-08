<?php

namespace OrbitMVC;

use OrbitMVC\Http\Request;
use OrbitMVC\Routing\Router;

class Application {
    protected Router $router;
    protected Request $request;
    protected \OrbitMVC\View\Engine $view;

    public function __construct() {
        $this->router = new Router();
        $this->request = new Request();
        $this->view = new \OrbitMVC\View\Engine(
            __DIR__ . '/../app/Views',
            __DIR__ . '/../storage/framework/views'
        );
    }

    public static function instance(): self {
        static $instance = null;
        if (!$instance) {
            $instance = new self();
        }
        return $instance;
    }

    public function view(): \OrbitMVC\View\Engine {
        return $this->view;
    }

    public function getRouter(): Router {
        return $this->router;
    }

    public function run() {
        try {
            $response = $this->router->dispatch($this->request);
            if (is_array($response) || is_object($response)) {
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                echo $response;
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}
