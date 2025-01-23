<?php

declare(strict_types=1);

namespace App\Domain\NewUser;

use JsonSerializable;

class User implements JsonSerializable
{
    private ?int $id;

    private string $name;

    private string $cpf;

    private int $privileges;

    private string $login;

    private string $password;

    private function __construct(?int $id, string $name, string $cpf, string $privileges, string $login, string $password)
    {
        $this->id = $id;
        $this->name = strtolower($name);
        $this->cpf = ucfirst($cpf);
        $this->privileges = ucfirst($privileges);
    }

    public function create(){



    }

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    // public function getUsername(): string
    // {
    //     return $this->username;
    // }

    // public function getFirstName(): string
    // {
    //     return $this->firstName;
    // }

    // public function getLastName(): string
    // {
    //     return $this->lastName;
    // }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            // 'username' => $this->username,
            // 'firstName' => $this->firstName,
            // 'lastName' => $this->lastName,
        ];
    }
}
