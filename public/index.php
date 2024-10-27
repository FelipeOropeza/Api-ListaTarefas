<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Incluir as rotas
(require __DIR__ . '/../config/routes.php')($app);

// Rodar a aplicação
$app->run();
