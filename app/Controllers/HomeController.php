<?php

namespace Felipe\ApiListatarefa\Controllers;

use Felipe\ApiListatarefa\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    public function sayHello(Request $request, Response $response, array $args): Response
    {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    }

    public function testedao(Request $request, Response $response, array $args): Response{
        $user = new User;
        $response->$user->testeConnection();
        return $response;
    }
}
