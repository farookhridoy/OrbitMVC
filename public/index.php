<?php

require_once __DIR__ . '/../vendor/autoload.php';

use OrbitMVC\Application;
use App\Services\RegistrationService;
use App\Services\SearchService;

$app = new Application();
$app->run();
