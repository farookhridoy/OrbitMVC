<?php

/**
 * OrbitMVC High-Performance Worker
 * This script processes background jobs from Redis.
 * Run this via CLI: php worker.php
 * Author: Md Omar farook
 */

require_once __DIR__ . '/vendor/autoload.php';

// Mock ENV for local test if not using a proper loader
$_ENV['REDIS_HOST'] = $_ENV['REDIS_HOST'] ?? '127.0.0.1';
$_ENV['REDIS_PORT'] = $_ENV['REDIS_PORT'] ?? 6379;

use OrbitMVC\Queue\RedisQueue;

$queue = new RedisQueue();

echo "[\e[32mOK\e[0m] OrbitMVC Worker started. Monitoring 'orbit_queue'...\n";

while (true) {
    // Blocking pop to save CPU
    if ($job = $queue->pop(5)) {
        echo "[\e[34mINFO\e[0m] [" . date('Y-m-d H:i:s') . "] Processing: " . $job['job'] . "\n";
        
        // Example handling logic
        try {
            // In a real framework, we'd use a Job class:
            // (new $job['job'])->handle($job['data']);
            
            // For now, simulate work
            usleep(500000); // 500ms
            
            echo "[\e[32mDONE\e[0m] Job ID: " . $job['id'] . " completed.\n";
        } catch (\Exception $e) {
            echo "[\e[31mERROR\e[0m] Job failed: " . $e->getMessage() . "\n";
        }
    }
}
