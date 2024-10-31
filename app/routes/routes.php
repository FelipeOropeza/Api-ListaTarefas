<?php

use Slim\App;

return function (App $app) {
    $app->get('/', function ($request, $response, $args) {
        $response->getBody()->write("Bem-vindo à API de Lista de Tarefas!");
        return $response;
    });

    (require __DIR__ . '/UserRoutes.php')($app);
    (require __DIR__ . '/AuthRoutes.php')($app);
};
