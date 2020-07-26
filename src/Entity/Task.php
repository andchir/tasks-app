<?php

namespace App\Entity;

class Task
{

    const STATUS_CREATED = 'created';
    const STATUS_FINISHED = 'finished';

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $status;
    /**
     * @var string
     */
    protected $description;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): Task
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Task
    {
        $this->email = $email;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): Task
    {
        $this->status = $status;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Task
    {
        $this->description = $description;
        return $this;
    }

    public function getDescriptionShort(): string
    {
        $description = strip_tags($this->getDescription());
        if (mb_strlen($description) > 100) {
            $description = trim(mb_substr($description, 0, 100), " \t\n\r\0\x0B.,") . '...';
        }
        return $description;
    }
}
