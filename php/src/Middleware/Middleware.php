<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class Middleware
{
    public function __invoke(Request $request, JsonResponse $response, $next) {
        return $this->handle($request, $response, $next);
    }

    public abstract function handle(Request $request, JsonResponse $response, $next);
}
