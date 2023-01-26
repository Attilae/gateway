<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

class TrafficCodeMiddleware extends Middleware
{
    public function handle(Request $request, JsonResponse $response, $next)
    {
        $trafficCodeCookieName = getenv('COOKIE_TRAFFIC_CODE_NAME');
        $trafficCodeCookieDomain = getenv('COOKIE_TRAFFIC_CODE_DOMAIN');

        $trafficCodeCookie = $request->cookies->get($trafficCodeCookieName);
        $trafficCodeQuery = $request->query->get($trafficCodeCookieName);

        if ($trafficCodeCookie !== null) {
            $trafficCode = $trafficCodeCookie;
        } else if ($trafficCodeQuery !== null) {
            $trafficCode = $trafficCodeCookie;
        } else {
            $trafficCode = getenv('COOKIE_TRAFFIC_CODE_DEFAULT_VALUE');
        }

        $trafficCodeCookie = new Cookie($trafficCodeCookieName, $trafficCode, 0, '/', $trafficCodeCookieDomain, false, true, false, null);

        $response->headers->setCookie($trafficCodeCookie);

        return $next($request, $response);
    }
}
