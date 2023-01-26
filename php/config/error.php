<?php

if (getenv('APP_ENV') !== 'prod') {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();    
} else {
    set_error_handler(function($level, $message, $file, $line, $context) use ($logger) {
        $logger->error('An error occured.', ['FILE' => $file, 'LINE' => $line, 'MESSAGE' => $message]);

        $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR;
        $response = new \Symfony\Component\HttpFoundation\JsonResponse(null, $statusCode);

        $response->send();
    }, E_ALL);

    set_exception_handler(function($exception) use ($logger) {
        $logger->error('An exception.', ['FILE' => __FILE__, 'LINE' => __LINE__, 'MESSAGE' => $exception->getMessage()]);

        $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR;
        $response = new \Symfony\Component\HttpFoundation\JsonResponse(null, $statusCode);

        $response->send();
    });
}
