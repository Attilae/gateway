<?php

namespace App\Factory;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\JsonFormatter;

class LoggerFactory
{
    public static function create(): LoggerInterface
    {
        $logger = new Logger(getenv('LOG_CHANNEL'));

        // Do not log to file on prod environment
        //if (getenv('APP_ENV') !== 'prod') {
            $fileHandler = new RotatingFileHandler(getenv('ROOT_FOLDER') . '/var/log/' . getenv('APP_ENV') . '.log', 0, Logger::DEBUG);
            $logger->pushHandler($fileHandler);
        //}

        $stdoutHandler = new StreamHandler('php://stdout', Logger::WARNING);
        $stdoutHandler->setFormatter(new JsonFormatter);
        $logger->pushHandler($stdoutHandler);

        $stderrHandler = new StreamHandler('php://stderr', Logger::ERROR);
        $stderrHandler->setFormatter(new JsonFormatter);
        $logger->pushHandler($stderrHandler);

        return $logger;
    }
}
