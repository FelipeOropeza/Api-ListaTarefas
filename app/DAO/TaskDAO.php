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

    public function findAllTasks(int $id)
    {
        try {
            $sql = "SELECT * FROM tasks WHERE user_id = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $tasks = [];
                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $tasks[] = new TaskModel(
                        $data['id'],
                        $data['user_id'],
                        $data['title'],
                        $data['description'],
                        $data['status'],
                        $data['priority'],
                        $data['due_date'],
                    );
                }
                return $tasks;
            }
            return null;
        } catch (\PDOException $e) {
            echo "Erro ao buscar as tarefas pelo id do usuário: " . $e->getMessage();
            return null;
        }
    }

    public function deleteTask(int $id)
{
    try {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return false;
        }

        return true;
    } catch (\PDOException $e) {
        echo "Erro ao deletar tarefa: " . $e->getMessage();
        return false;
    }
}

}
