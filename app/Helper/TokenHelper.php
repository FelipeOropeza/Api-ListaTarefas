<?php

namespace Felipe\ApiListatarefa\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenHelper
{
    private static $key = $_ENV["SECRET_KEY"];

    public static function generateToken($userId) {
        $payload = [
            'iss' => 'localhost',
            'aud' => 'localhost',
            'iat' => time(),
            'exp' => time() + 86400,
            'sub' => $userId
        ];

        return JWT::encode($payload, self::$key, 'HS256');
    }

    public static function verifyToken($token) {
        try {
            return JWT::decode($token, new Key(self::$key, 'HS256'));
        } catch (\Exception $e) {
            return null; // Retorne null ou uma exceção personalizada para token inválido
        }
    }
}