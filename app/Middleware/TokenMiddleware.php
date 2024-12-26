<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use App\Helper\TokenHelper;

class TokenMiddleware
{
    public function __invoke(Request $request, Handler $handler): Response
    {
        $authHeader = $request->getHeader('Authorization');
        if (!$authHeader) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write("Token not provided");
            return $response->withStatus(401);
        }

        $token = str_replace('Bearer ', '', $authHeader[0]);

        $decodedToken = TokenHelper::verifyToken($token);
        if (!$decodedToken) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write("Invalid token");
            return $response->withStatus(401);
        }

        $request = $request->withAttribute('id', $decodedToken->sub);
        return $handler->handle($request);
    }
}
