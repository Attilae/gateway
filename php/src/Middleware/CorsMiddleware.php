<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CorsMiddleware extends Middleware
{
    public function handle(Request $request, JsonResponse $response, $next)
    {
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', '*');        

        return $next($request, $response);
    }
}
