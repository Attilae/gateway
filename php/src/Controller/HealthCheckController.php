<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class HealthCheckController extends Controller
{
    public function check(Request $request, JsonResponse $response): JsonResponse
    {
        return $response;
    }
}
