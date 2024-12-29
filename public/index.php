<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Helper\TokenHelper;
use Slim\Factory\AppFactory;
use Tuupola\Middleware\CorsMiddleware;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

TokenHelper::initializeKey();

$app = AppFactory::create();

$app->add(new CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "DELETE", "OPTIONS"],
    "headers.allow" => ["Authorization", "Content-Type", "Accept", "Origin"],
    "headers.expose" => ["Authorization"],
    "credentials" => true,
    "cache" => 0,
]));

(require __DIR__ . '/../app/Routes/Routes.php')($app);


$app->run();
