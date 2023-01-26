<?php

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
require __DIR__ . '/../config/env.php';

// Create new logger instance
$logger = \App\Factory\LoggerFactory::create();

// Register error/exception handlers
require __DIR__ . '/../config/error.php';

// // Register routing
require __DIR__ . '/../config/router.php';
