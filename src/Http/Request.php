<?php

namespace OrbitMVC\Http;

class Request {
    public function uri() {
        return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    }

    public function method() {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function input($key = null) {
        $input = json_decode(file_get_contents('php://input'), true) ?? $_REQUEST;
        return $key ? ($input[$key] ?? null) : $input;
    }
}
