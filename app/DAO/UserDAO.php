<?php

namespace Felipe\ApiListatarefa\DAO;

use PDO;
use Felipe\ApiListatarefa\Model\UserModel;

class UserDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findById(int $id): ?UserModel
    {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return new UserModel($data['id'], $data['username'], $data['email'], $data['password']);
            }

            return null;
    
        } catch (\PDOException $e) {
            echo "Erro ao buscar usuário pelo id: " . $e->getMessage();
            return null;
        }
    }

    public function insertUser(UserModel $user): bool
    {
        try {
            $sql = "INSERT INTO users (username, email, password) VALUES (:name, :email, :password)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':name', $user->getName());
            $stmt->bindValue(':email', $user->getEmail());
            $stmt->bindValue(':password', $user->getPassword());
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Erro ao inserir usuário: " . $e->getMessage();
            return false;
        }
    }

    public function findByEmail(string $email): ?UserModel 
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return new UserModel($data['id'], $data['username'], $data['email'], $data['password']);
            }

            return null;
    
        } catch (\PDOException $e) {
            echo "Erro ao buscar usuário pelo email: " . $e->getMessage();
            return null;
        }
    }
    
}
