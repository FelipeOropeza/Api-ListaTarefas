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
        try {
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);

            $user = new UserModel(
                0,
                $data['name'],
                $data['email'],
                $data['password']
            );

            $userDAO = new UserDAO();
            if ($userDAO->insertUser($user)) {
                $response->getBody()->write(json_encode(["message" => "Usuário criado com sucesso!"], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(201);
            } else {
                $response->getBody()->write(json_encode(["message" => "Erro ao criar usuário."], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(500);
            }
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(400);
        }
    }

    public function getUserById(Request $request, Response $response, $args): Response
    {
        try {
            $userId = (int) $args['id'];
            $userDAO = new UserDAO();

            $user = $userDAO->findById($userId);
            if (!$user) {
                $response->getBody()->write(json_encode(["message" => "O Usuário não foi encontrado."], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(404);
            }

            $response->getBody()->write(json_encode([
                "id" => $user->getId(),
                "name" => $user->getName(),
                "email" => $user->getEmail(),
            ]));

            return $response->withStatus(200);
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(400);
        }
    }
}
