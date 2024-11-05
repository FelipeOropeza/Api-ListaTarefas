<?php

namespace Felipe\ApiListatarefa\Model;

class TaskModel
{
    private int $id;
    private int $userid;
    private string $title;
    private string $description;
    private string $status;
    private string $priority;
    private ?string $due_date;

    public function __construct(
        int $id = 0,
        int $userid = 0,
        string $title = '',
        string $description = '',
        string $status = '',
        string $priority = '',
        ?string $due_date = null
    ) {
        $this->setId($id);
        $this->setUserId($userid);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setStatus($status);
        $this->setPriority($priority);
        $this->setDueDate($due_date);
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

    public function setStatus(string $status): void
    {
        if (empty(trim($status))) {
            throw new \InvalidArgumentException("O status não pode estar vazio.");
        }
        $this->status = $status;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): void
    {
        if (empty(trim($priority))) {
            throw new \InvalidArgumentException("O prioridade não pode estar vazia.");
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
}
