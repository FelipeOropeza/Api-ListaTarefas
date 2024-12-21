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
                $data["user_id"],
                $data["title"],
                $data["description"],
                $data["status"] ?? 'pendente',
                $data["priority"] ?? 'media',
                $data["due_date"] ?? null
            );

            $taskDAO = new TaskDAO();
            if ($taskDAO->insertTask($task)) {
                $response->getBody()->write(json_encode(["message" => "Tarefa criada com sucesso!"], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(201);
            } else {
                $response->getBody()->write(json_encode(["message" => "Erro ao criar Tarefa."], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(500);
            }
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(400);
        }
    }

    public function getAllTask(Request $request, Response $response, $args)
    {
        try {
            $userId = (int) $args['id'];
            $taksDAO = new TaskDAO();
            $tasks = $taksDAO->findAllTasks($userId);

            if (!$tasks) {
                $response->getBody()->write(json_encode(["message" => "As Tarefas não foram encontradas."], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(404);
            }

            $response->getBody()->write(json_encode(
                array_map(function ($task) {
                    return [
                        'id' => $task->getId(),
                        'user_id' => $task->getUserId(),
                        'title' => $task->getTitle(),
                        'description' => $task->getDescription(),
                        'status' => $task->getStatus(),
                        'priority' => $task->getPriority(),
                        'due_date' => $task->getDueDate(),
                    ];
                }, $tasks),
                JSON_UNESCAPED_UNICODE
            ));


            return $response->withStatus(200);
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()], flags: JSON_UNESCAPED_UNICODE));
            return $response->withStatus(400);
        }
    }

    public function updateTask(Request $request, Response $response, $args){
        try {
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);
            $taskId = (int) $args['id'];
            
            $taks = new TaskModel(
                $taskId,
                $data['user_id'],
                $data['title'],
                $data['description'],
                $data['status'],
                $data['priority'],
                $data['due_date'] ?? null,
            );
            
            $taksDAO = new TaskDAO();

            if($taksDAO->updateTask($taks)){
                $response->getBody()->write(json_encode(["message" => "Tarefa atualizada com sucesso!"], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(200);
            } else {
                $response->getBody()->write(json_encode(["message" => "Não foi possível atualizar a tarefa: tarefa não encontrada."], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(404);
            }

        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()], flags: JSON_UNESCAPED_UNICODE));
            return $response->withStatus(400);
        }
    }

    public function deleteTask(Request $request, Response $response, $args)
    {
        try {
            $taskId = (int) $args['id'];
            $taksDAO = new TaskDAO();

            if ($taksDAO->deleteTask($taskId)) {
                $response->getBody()->write(json_encode(["message" => "Tarefa deletada com sucesso!"], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(200);
            } else {
                $response->getBody()->write(json_encode(["message" => "Não foi possível deletar a tarefa: tarefa não encontrada."], JSON_UNESCAPED_UNICODE));
                return $response->withStatus(404);
            }
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(["message" => $e->getMessage()], flags: JSON_UNESCAPED_UNICODE));
            return $response->withStatus(400);
        }
    }
}
