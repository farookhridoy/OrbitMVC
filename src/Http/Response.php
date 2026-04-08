<?php

namespace OrbitMVC\Http;

class Response {
    public function json($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    public function send($content, $status = 200) {
        http_response_code($status);
        echo $content;
    }
}
