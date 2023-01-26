<?php

$dispatcher = FastRoute\cachedDispatcher(function(FastRoute\RouteCollector $route) {
    require __DIR__ . '/routes.php';
}, [
    'cacheFile' => __DIR__ . '/../var/cache/route.cache',
    'cacheDisabled' => getenv('APP_ENV') === 'prod' ? false : true
]);

// Fetch method and URI
$httpMethod = getenv('REQUEST_METHOD');
$uri = getenv('REQUEST_URI');

// Strip query string and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

$logger->info("New '$httpMethod' request to '$uri' endpoint", ['FILE' => __FILE__, 'LINE' => __LINE__]);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        header('404 Not Found', true, 404);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        header('405 Method Not Allowed', true, 405);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // Build request object
        $request = new Symfony\Component\HttpFoundation\Request(
            $vars,
            json_decode(file_get_contents('php://input'), true) ?? [],
            [],
            $_COOKIE,
            $_FILES,
            $_SERVER
        );

        $middlewares = [];

        // Route contains middlewares
        if (is_array($handler)) {
            $middlewares = $handler['middlewares'];
            $handler = $handler['action'];
        }

        // Actual call to the controller action
        $callback = function($request, $response) use ($handler) {
            list($class, $method) = explode('/', $handler, 2);

            return (new $class)->$method($request, $response);
        };

        // Build middleware callback chain
        foreach ($middlewares as $middleware) {
            $callback = function($request, $response) use ($middleware, $callback) {
                return (new $middleware)($request, $response, $callback);
            };
        }

        $response = $callback($request, new Symfony\Component\HttpFoundation\JsonResponse);

        return $response->send();
}
