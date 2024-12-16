<?php

namespace Felipe\ApiListatarefa\DAO;

use PDO;
use Felipe\ApiListatarefa\Model\TaskModel;

class TaskDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertTask(TaskModel $task)
    {
        try {
            $sql = "INSERT INTO tasks (user_id, title, description, status, priority, due_date) VALUES (:user_id, :title, :description, :status, :priority, :due_date)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':user_id', $task->getUserId());
            $stmt->bindValue(':title', $task->getTitle());
            $stmt->bindValue(':description', $task->getDescription());
            $stmt->bindValue(':status', $task->getStatus());
            $stmt->bindValue(':priority', $task->getPriority());
            $stmt->bindValue(':due_date', $task->getDueDate());
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Erro ao inserir tarefa: " . $e->getMessage();
            return false;
        }
    }
}
