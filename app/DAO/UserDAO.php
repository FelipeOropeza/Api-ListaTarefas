<?php

namespace App\DAO;

use PDO;
use App\Model\UserModel;

class UserDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findById(int $id)
    {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return new UserModel($data['id'], $data['name'], $data['email'], $data['password']);
            }

            return null;
        } catch (\PDOException $e) {
            echo "Erro ao buscar usuário pelo id: " . $e->getMessage();
            return null;
        }
    }

    public function insertUser(UserModel $user)
    {
        try {
            $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':name', $user->getName());
            $stmt->bindValue(':email', $user->getEmail());
            $stmt->bindValue(':password', $user->getPassword());
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return 'Nome de usuário ou e-mail já está em uso. Tente outro.';
            } else {
                return 'Erro ao inserir usuário: ' . $e->getMessage();
            }
        }
    }

    public function updateUser(UserModel $user)
    {
        try {
            $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':id', $user->getId());
            $stmt->bindValue(':name', $user->getName());
            $stmt->bindValue(':email', $user->getEmail());
            $stmt->bindValue(':password', $user->getPassword());
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                return false;
            }

            return true;
        } catch (\PDOException $e) {
            echo "Erro ao atualizar usuário: " . $e->getMessage();
            return false;
        }
    }

    public function deleteUser(int $id)
    {
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                return false;
            }

            return true;
        } catch (\PDOException $e) {
            echo "Erro ao deletar usuário: " . $e->getMessage();
            return false;
        }
    }


    public function findByEmail(string $email)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return new UserModel($data['id'], $data['name'], $data['email'], $data['password']);
            }

            return null;
        } catch (\PDOException $e) {
            echo "Erro ao buscar usuário pelo email: " . $e->getMessage();
            return null;
        }
    }
}
