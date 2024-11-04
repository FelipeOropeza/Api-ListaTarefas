<?php

namespace Felipe\ApiListatarefa\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Felipe\ApiListatarefa\Model\UserModel;
use Felipe\ApiListatarefa\DAO\UserDAO;
use PasswordHelper;

class UserController
{
    public function createUser(Request $request, Response $response): Response
    {
        try {
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);
            $passwordHash = PasswordHelper::hashPassword($data['password']);

            $user = new UserModel(
                0,
                $data['name'],
                $data['email'],
                $passwordHash
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

    public function updateUser(Request $request, Response $response, $args): Response
    {
        try {
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);
            $userId = (int) $args['id'];
            $passwordHash = PasswordHelper::hashPassword($data['password']);

            $user = new UserModel(
                $userId,
                $data['name'],
                $data['email'],
                $passwordHash
            );

            $userDAO = new UserDAO();
            if ($userDAO->updateUser($user)) {
                $response->getBody()->write(json_encode(["message" => "Usuário atualizado com sucesso!"], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(200);
            } else {
                $response->getBody()->write(json_encode(["message" => "Não foi possível atualizar o usuário: usuário não encontrado."], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(404);
            }
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(400);
        }
    }
    public function deleteUser(Request $request, Response $response, $args): Response
    {
        try {
            $userId = (int) $args['id'];

            $userDAO = new UserDAO();
            if ($userDAO->deleteUser($userId)) {
                $response->getBody()->write(json_encode(["message" => "Usuário deletado com sucesso!"], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(200);
            } else {
                $response->getBody()->write(json_encode(["message" => "Não foi possível deletar o usuário: usuário não encontrado."], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(404);
            }
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(400);
        }
    }
}
