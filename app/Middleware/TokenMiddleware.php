<?php

namespace Felipe\ApiListatarefa\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Felipe\ApiListatarefa\Helper\TokenHelper;

class TokenMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        $authHeader = $request->getHeader('Authorization');
        if (!$authHeader) {
            $response->getBody()->write("Token not provided");
            return $response->withStatus(401);
        }

        $token = str_replace('Bearer ', '', $authHeader[0]);

        $decodedToken = TokenHelper::verifyToken($token);
        if (!$decodedToken) {
            $response->getBody()->write("Invalid token");
            return $response->withStatus(401);
        }

        $request = $request->withAttribute('id', $decodedToken->sub);
        return $next($request, $response);
    }
}
