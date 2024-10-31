<?php

namespace Felipe\ApiListatarefa\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Felipe\ApiListatarefa\Model\UserModel;
use Felipe\ApiListatarefa\DAO\UserDAO;

class UserController
{
    public function createUser(Request $request, Response $response): Response
    {
        $body = $request->getBody()->getContents();
        $data = json_decode($body, true);

        try {
            $user = new UserModel(
                0,
                $data['name'],
                $data['email'],
                $data['password']
            );

            $userDAO = new UserDAO();
            if ($userDAO->insert($user)) {
                $response->getBody()->write(json_encode(["message" => "Usuário criado com sucesso!"]));
                return $response->withStatus(201);
            } else {
                $response->getBody()->write(json_encode(["message" => "Erro ao criar usuário."]));
                return $response->withStatus(500);
            }
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()]));
            return $response->withStatus(400);
        }
    }
}
