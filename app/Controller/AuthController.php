<?php

namespace Felipe\ApiListatarefa\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Felipe\ApiListatarefa\DAO\UserDAO;
use Felipe\ApiListatarefa\Helper\TokenHelper;

class AuthController
{
    public function login(Request $request, Response $response, $args): Response
    {
        $body = $request->getBody()->getContents();
        $data = json_decode($body, true);

        $userDAO = new UserDAO();

        if (empty($data['email']) || empty($data['password'])) {
            $response->getBody()->write(json_encode(["message" => "Email e senha são obrigatórios."]));
            return $response->withStatus(400);
        }

        $user = $userDAO->findByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user->getPassword())) {
            $response->getBody()->write(json_encode(["message" => "Email ou senha inválidos."]));
            return $response->withStatus(401);
        }

        $token = TokenHelper::generateToken($user->getId());

        $response->getBody()->write(json_encode([
            "id" => $user->getId(),
            "name" => $user->getName(),
            "token" => $token
        ]));

        return $response->withStatus(200);
    }

    public function logout(Request $request, Response $response, $args): Response
    {
        $response->getBody()->write(json_encode(["message" => "Logout realizado com sucesso."]));
        return $response->withStatus(200);
    }
}
