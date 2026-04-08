<?php

namespace App\Services;

use OrbitMVC\Database\Connection;
use OrbitMVC\Queue\RedisQueue;

class RegistrationService {
    protected RedisQueue $queue;

    public function __construct() {
        $this->queue = new RedisQueue();
    }

    public function register(array $data) {
        // 1. Basic validation (Instant)
        if (empty($data['email'])) return false;

        // 2. Push to queue (High performance, doesn't wait for DB/Email)
        return $this->queue->push('UserRegistrationJob', [
            'email' => $data['email'],
            'username' => $data['username'],
            'ip' => $_SERVER['REMOTE_ADDR']
        ]);
    }
}

class SearchService {
    protected \Redis $redis;

    public function __construct() {
        $this->redis = new \Redis();
        $this->redis->connect($_ENV['REDIS_HOST'] ?? '127.0.0.1', $_ENV['REDIS_PORT'] ?? 6379);
    }

    public function search(string $query) {
        $key = "search:" . md5($query);

        // 1. Try Cache First (Essential for 70k concurrent users)
        if ($cached = $this->redis->get($key)) {
            return json_decode($cached, true);
        }

        // 2. Cache Miss: Simulate DB Search
        // In reality, you'd query the DB here
        $results = [
            ["id" => 1, "title" => "Result for $query"],
            ["id" => 2, "title" => "Another item related to $query"]
        ];

        // 3. Set Cache with TTL (e.g., 5 mins)
        $this->redis->setex($key, 300, json_encode($results));

        return $results;
    }
}
