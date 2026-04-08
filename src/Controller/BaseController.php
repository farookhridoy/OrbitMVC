<?php

namespace OrbitMVC\Controller;

use OrbitMVC\Http\Response;

abstract class BaseController {
    protected Response $response;

    public function __construct() {
        $this->response = new Response();
    }

    protected function json($data, int $status = 200) {
        return $this->response->json($data, $status);
    }

    protected function view(string $view, array $data = []) {
        echo \OrbitMVC\Application::instance()->view()->render($view, $data);
    }
}
