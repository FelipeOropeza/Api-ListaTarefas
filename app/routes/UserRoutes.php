<?php

use Felipe\ApiListatarefa\Controller\UserController;
use Felipe\ApiListatarefa\Middleware\TokenMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/users/{id}', [UserController::class, 'getUserById'])->add(new TokenMiddleware());
    $app->post('/users', [UserController::class, 'createUser']);
    $app->put('/users/{id}', [UserController::class, 'updateUser'])->add(new TokenMiddleware());
    $app->delete('/users/{id}', [UserController::class, 'deleteUser'])->add(new TokenMiddleware());
};
