<?php

namespace App\Model;

readonly final class UserModel
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(int $id = 0, string $name = '', string $email = '', string $password = '')
    {
        $this->setId($id);
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        if (empty(trim($name))) {
            throw new \InvalidArgumentException("O nome não pode estar vazio.");
        }
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        if (empty(trim($email))) {
            throw new \InvalidArgumentException("O email não pode estar vazio.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email inválido.");
        }
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        if (empty(trim($password))) {
            throw new \InvalidArgumentException("A senha não pode estar vazia.");
        }
        if (strlen($password) < 8) {
            throw new \InvalidArgumentException("A senha deve ter pelo menos 8 caracteres.");
        }
        $this->password = $password;

    }
}
