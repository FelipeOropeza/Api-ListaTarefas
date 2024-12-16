<?php

namespace Felipe\ApiListatarefa\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Felipe\ApiListatarefa\Model\TaskModel;
use Felipe\ApiListatarefa\DAO\TaskDAO;

class TaskController
{
    public function createTask(Request $request, Response $response)
    {
        try {
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);

            $task = new TaskModel(
                0,
                $data["userId"],
                $data["title"],
                $data["description"],
                $data["status"] ?? 'pendente',
                $data["priority"] ?? 'media',
                $data["due_date"]
            );

            var_dump($task);
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(400);
        }
    }

    public function getAllTask(Request $request, Response $response, $args){
        try {
            $userId = (int) $args['id'];
            var_dump($userId);
            
            return $response->withStatus(200);
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(400);
        }
    }
}
