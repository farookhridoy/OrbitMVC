<?php

namespace App\Middleware;

use Core\Cache;

class RateLimitMiddleware {
    public function handle() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $key = "rl:$ip";
        $current = Cache::increment($key);
        
        if ($current === 1) Cache::expire($key, 60);
        if ($current > $_ENV['RATE_LIMIT']) {
            http_response_code(429);
            die(json_encode(["error" => "Slow down! Server busy."]));
        }
    }
}
