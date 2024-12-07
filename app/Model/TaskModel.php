<?php

namespace Felipe\ApiListatarefa\Model;

class TaskModel
{
    private int $id = 0;
    private int $userid = 0;
    private string $title = '';
    private string $description = '';
    private string $status = 'pendente';
    private string $priority = 'media';
    private ?string $due_date = null;
    
    private ?UserModel $user = null;

    public function __construct(
        int $id = 0,
        int $userid = 0,
        string $title = '',
        string $description = '',
        string $status = '',
        string $priority = '',
        ?string $due_date = null,
        ?UserModel $user = null
    ) {
        $this->setId($id);
        $this->setUserId($userid);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setStatus($status ?: 'pendente');
        $this->setPriority($priority ?: 'media');
        $this->setDueDate($due_date);
        $this->setUser($user);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userid;
    }

    public function setUserId(int $userid): void
    {
        if (empty($userid)) {
            throw new \InvalidArgumentException("O Id do Usuario não pode estar vazio.");
        }
        $this->userid = $userid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        if (empty(trim($title))) {
            throw new \InvalidArgumentException("O Titulo não pode estar vazio.");
        }
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        if (empty(trim($description))) {
            throw new \InvalidArgumentException("A descrição não pode estar vazia.");
        }
        $this->description = $description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $arrayStatus = ["pendente", "em_progresso", "concluida"];

        if (empty(trim($status))) {
            $this->status = 'pendente';
            return;
        }

        if (!in_array($status, $arrayStatus)) {
            throw new \InvalidArgumentException("Status inválido.");
        }

        $this->status = $status;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): void
    {
        $arrayPriority = ["baixa", "media", "alta"];

        if (empty(trim($priority))) {
            $this->priority = 'media';
            return;
        }

        if (!in_array($priority, $arrayPriority)) {
            throw new \InvalidArgumentException("Prioridade inválida.");
        }

        $this->priority = $priority;
    }

    public function getDueDate(): ?string
    {
        return $this->due_date;
    }

    public function setDueDate(?string $due_date): void
    {
        $this->due_date = $due_date;
    }

    public function getUser(): ?UserModel
    {
        return $this->user;
    }

    public function setUser(?UserModel $user): void
    {
        $this->user = $user;
    }
}
