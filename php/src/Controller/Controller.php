<?php

namespace App\Controller;

use App\Factory\ValidatorFactory;
use App\Factory\LoggerFactory;

abstract class Controller
{
    protected $validator;

    protected $logger;

    public function __construct()
    {
        $this->validator = ValidatorFactory::create();
        $this->logger = LoggerFactory::create();
    }
}
