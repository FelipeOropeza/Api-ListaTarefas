<?php

use Felipe\ApiListatarefa\Controller\UserController;
use Slim\App;

return function (App $app) {
    $app->post('/users', [UserController::class, 'createUser']);
};
