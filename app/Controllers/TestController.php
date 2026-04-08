<?php

namespace App\Controllers;

use OrbitMVC\Controller\BaseController;

class TestController extends BaseController {
    public function index() {
        return $this->json(['message' => 'Hello from TestController']);
    }
}
