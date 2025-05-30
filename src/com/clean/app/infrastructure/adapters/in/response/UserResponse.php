<?php

namespace Infrastructure\adapters\in\response;

class UserResponse
{
    private string $id;
    private string $name;
    private string $email;

    public function __construct(string $id, string $name, string $email)
    {
        $this->id    = $id;
        $this->name  = $name;
        $this->email = $email;
    }

    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
        ];
    }
}