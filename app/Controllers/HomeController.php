<?php

namespace Felipe\ApiListatarefa\Controllers;

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
}
