<?php

use Felipe\ApiListatarefa\Controllers\HomeController;
use Slim\App;

return function (App $app) {
    // Rota para a URL raiz '/'
    $app->get('/', function ($request, $response, $args) {
        $response->getBody()->write("Bem-vindo à API de Lista de Tarefas!");
        return $response;
    });

    $app->get('/hello/{name}', [HomeController::class, 'sayHello']);
    $app->get('/dao', [HomeController::class, 'testedao']);
};
