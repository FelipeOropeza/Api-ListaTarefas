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

    public function insert(UserModel $user): bool
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
    
        } catch (\PDOException $e) {
            echo "Erro ao buscar usuário: " . $e->getMessage();
            return null;
        }
    }
    
}
