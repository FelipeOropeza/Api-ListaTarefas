<?php

use Felipe\ApiListatarefa\Controller\UserController;
use Felipe\ApiListatarefa\Middleware\TokenMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/users/{id}', [UserController::class, 'getUserById'])->add(new TokenMiddleware());
    $app->post('/users', [UserController::class, 'createUser']);
};
