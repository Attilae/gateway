<?php

if (!file_exists(__DIR__ . '/../.env')) {
    return;
}

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
$dotenv->load();
