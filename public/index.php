<?php

require __DIR__ . '/../vendor/autoload.php';

use Felipe\ApiListatarefa\Helper\TokenHelper;
use Slim\Factory\AppFactory;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

TokenHelper::initializeKey();

$app = AppFactory::create();

(require __DIR__ . '../../app/Routes/Routes.php')($app);

$app->run();
