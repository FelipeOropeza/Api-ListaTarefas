<?php

use Felipe\ApiListatarefa\Controller\TaskController;
use Felipe\ApiListatarefa\Middleware\TokenMiddleware;
use Slim\App;

return function (App $app) {
    $app->post('/tasks', [TaskController::class, 'createTask'])->add(new TokenMiddleware());
    $app->get('/tasks/{id}', [TaskController::class, 'getAllTask'])->add(new TokenMiddleware());
};
