<?php

namespace OrbitMVC\Queue;

class RedisQueue {
    protected \Redis $redis;
    protected string $queueName = 'orbit_queue';

    public function __construct() {
        $this->redis = new \Redis();
        // Fallback to localhost if ENV not set
        $host = $_ENV['REDIS_HOST'] ?? '127.0.0.1';
        $port = $_ENV['REDIS_PORT'] ?? 6379;
        
        try {
            $this->redis->connect($host, (int)$port);
        } catch (\Exception $e) {
            // Silently fail or log in high-scale app
        }
    }

    public function push(string $job, array $data = []): bool {
        $payload = json_encode([
            'job' => $job,
            'data' => $data,
            'id' => uniqid('job_', true),
            'timestamp' => time()
        ]);
        return (bool)$this->redis->lPush($this->queueName, $payload);
    }

    public function pop(int $timeout = 0): ?array {
        // Use BRPOP for efficiency (blocking pop)
        $result = $this->redis->brPop($this->queueName, $timeout);
        
        if (!$result) return null;
        
        return json_decode($result[1], true);
    }
}
