<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RequestsLogger
{
    /**
     * Logs incoming API requests to the default laravel log.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->start = microtime(true);
        return $next($request);
    }

    public function terminate($request, $response){
        $request->end = microtime(true);
        $this->log($request, $response);
    }

    protected function log($request, $response){
        $duration = $request->end - $request->start;
        $url = $request->fullUrl();
        $method = $request->getMethod();
        $ip = $request->getClientIp();
        $requestParams = json_encode($request->toArray());
        $logMessage =
            "{$ip}: {$method}@{$url} - {$duration}ms \n".
            "Request: {$requestParams} \n".
            "Response: {$response->getContent()} \n";
        Log::info($logMessage);
    }
}

