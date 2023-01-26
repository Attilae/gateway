<?php

$route->addRoute('GET', '/health/check', 'App\Controller\HealthCheckController/check');

$gatewayController = 'App\Controller\GatewayController';

$route->addRoute('OPTIONS', '{any:.*}', [
    'action' => "$gatewayController/options",
    'middlewares' => [App\Middleware\CorsMiddleware::class]
]);
/** 
 * 
 * FRONTEND
 * 
 */
$route->addRoute('GET', '/profile/filters', [
    'action' => "$gatewayController/profileFilters",
    'middlewares' => [App\Middleware\TrafficCodeMiddleware::class, App\Middleware\CorsMiddleware::class]
]);
$route->addRoute('GET', '/profile/sign{any:.*}', [
    'action' => "$gatewayController/sign",
    'middlewares' => [App\Middleware\TrafficCodeMiddleware::class, App\Middleware\CorsMiddleware::class]
]);
$route->addRoute(['GET', 'POST'], '/profiles[/{page:\d+}]', [
    'action' => "$gatewayController/filterProfiles",
    'middlewares' => [App\Middleware\TrafficCodeMiddleware::class, App\Middleware\CorsMiddleware::class]
]);
$route->addRoute('GET', '/profile/{identifier}', [
    'action' => "$gatewayController/showProfile",
    'middlewares' => [App\Middleware\TrafficCodeMiddleware::class, App\Middleware\CorsMiddleware::class]
]);
$route->addRoute('GET', '/profile/{identifier:[a-zA-Z0-9]{32}}/products', [
    'action' => "$gatewayController/profileProducts",
    'middlewares' => [App\Middleware\TrafficCodeMiddleware::class, App\Middleware\CorsMiddleware::class]
]);
$route->addRoute('GET', '/profiles/online', [
    'action' => "$gatewayController/profilesOnline",
    'middlewares' => [App\Middleware\TrafficCodeMiddleware::class, App\Middleware\CorsMiddleware::class]
]);

/**
 * 
 * PROFILE MANAGEMENT
 * 
 */
$route->addRoute(['GET'], '/management/profile/{identifier:[a-zA-Z0-9]{32}}/{type}', [
    'action' => "$gatewayController/getProfile",
    'middlewares' => [App\Middleware\CorsMiddleware::class]
]);
$route->addRoute(['POST'], '/management/profile[/{identifier:[a-zA-Z0-9]{32}}]', [
    'action' => "$gatewayController/saveProfile",
    'middlewares' => [App\Middleware\CorsMiddleware::class]
]);
$route->addRoute(['POST'], '/management/profile/{identifier:[a-zA-Z0-9]{32}}/online[/{type:merchant}]', [
    'action' => "$gatewayController/online",
    'middlewares' => [App\Middleware\CorsMiddleware::class]
]);
$route->addRoute(['POST'], '/management/profile/{identifier:[a-zA-Z0-9]{32}}/offline[/{type:merchant}]', [
    'action' => "$gatewayController/offline",
    'middlewares' => [App\Middleware\CorsMiddleware::class]
]);
$route->addRoute(['POST'], '/management/profile/{identifier:[a-zA-Z0-9]{32}}/update-product-types[/{type:merchant}]', [
    'action' => "$gatewayController/updateProfileProductTypes",
    'middlewares' => [App\Middleware\CorsMiddleware::class]
]);
$route->addRoute(['POST'], '/management/profile/{identifier:[a-zA-Z0-9]{32}}/avatar[/{type:merchant}]', [
    'action' => "$gatewayController/avatar",
    'middlewares' => [App\Middleware\CorsMiddleware::class]
]);
$route->addRoute(['POST'], '/management/profile/{identifier:[a-zA-Z0-9]{32}}/cover[/{type:merchant}]', [
    'action' => "$gatewayController/cover",
    'middlewares' => [App\Middleware\CorsMiddleware::class]
]);

/**
 * 
 * PRODUCT MANAGEMENT
 * 
 */
$route->addRoute(['POST'], '/management/product/{identifier:[a-zA-Z0-9]{32}}/{type}', [
    'action' => "$gatewayController/saveProduct",
    'middlewares' => [App\Middleware\CorsMiddleware::class]
]);

$route->addRoute(['POST'], '/management/product/{identifier:[a-zA-Z0-9]{32}}/delete/{type}', [
    'action' => "$gatewayController/deleteProduct",
    'middlewares' => [App\Middleware\CorsMiddleware::class]
]);