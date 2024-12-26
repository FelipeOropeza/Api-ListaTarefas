<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\DAO\UserDAO;
use App\Helper\TokenHelper;
use App\Helper\PasswordHelper;

class AuthController
{
    public function login(Request $request, Response $response, $args)
    {
        try {
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);

            $userDAO = new UserDAO();

            if (empty($data['email']) || empty($data['password'])) {
                $response->getBody()->write(json_encode(["message" => "Email e senha são obrigatórios."], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(400);
            }

            $user = $userDAO->findByEmail($data['email']);

            if (!$user || !PasswordHelper::verifyPassword($data['password'], $user->getPassword())) {
                $response->getBody()->write(json_encode(["message" => "Email ou senha inválidos."], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(401);
            }

            $token = TokenHelper::generateToken($user->getId());

            $response->getBody()->write(json_encode([
                "id" => $user->getId(),
                "name" => $user->getName(),
                "token" => $token
            ], JSON_UNESCAPED_UNICODE));

            return $response->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(400);
        }
    }

    public function logout(Request $request, Response $response, $args)
    {
        $response->getBody()->write(json_encode(["message" => "Logout realizado com sucesso."], JSON_UNESCAPED_UNICODE));
        return $response->withStatus(200);
    }
}
