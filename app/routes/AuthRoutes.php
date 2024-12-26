<?php

use App\Controller\AuthController;
use Slim\App;

return function (App $app) {
    $app->post('/auth/login', [AuthController::class, 'login']);
    $app->post('/auth/logout', [AuthController::class, 'logout']);;
};
