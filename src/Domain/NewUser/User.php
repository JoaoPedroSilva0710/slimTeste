<?php

declare(strict_types=1);

namespace App\Domain\NewUser;

use Exception;
use JsonSerializable;
use App\Domain\NewUser\Privileges;

class User implements JsonSerializable
{
    const INVALID_ID = 'Este usuário não existe no banco de dados';
    const INVALID_NAME = 'O nome do usuário é inválido';
    const INVALID_SHORT_NAME = 'O nome do paciente deve ter no mínimo 3 caracteres';
    const INVALID_EMAIL = 'Este e-mail é inválido';
    const INVALID_CPF = 'Este CPF é inválido';
    const INVALID_PRIVILEGES = 'Este tipo de privilégio não existe';
    const INVALID_ATIVO = 'O ativo deve ser do tipo booleano';
    const INVALID_SHORT_PASSWORD = 'A senha deve possuir no minímo 8 caracteres';
    const INVALID_NOT_NUMBER_IN_PASSWORD = 'A senha deve possuir no minímo 1 número';
    const INVALID_NOT_LETTER_IN_PASSWORD = 'A senha deve possuir no minímo 1 letra';

    private function __construct(public readonly ?int $id, public readonly string $name, public readonly string $cpf, public readonly string $email, public readonly string $password, public readonly string $privileges, public readonly ?bool $active)
    {

    }

    public function create(?int $id, string $name, string $cpf, string $email, string $password, string $privileges, ?bool $active): self
    {
        return new self(self::idValidation($id), self::nameValidation($name),  self::cpfValidation($cpf), self::emailValidation($email), self::PasswordStrength($password), self::VerifyPrivileges($privileges), $active);

    }

    private static function nameValidation(string $name)
    {
        $pattern = '/^[a-záéíóúâêôãõç ]+$/ui';
        if(!preg_match($pattern, $name)) throw new Exception(self::INVALID_NAME, 400);

        if(strlen($name) < 3) throw new Exception(self::INVALID_SHORT_NAME, 400);

        return $name;       
    }

    private static function idValidation(?int $id): ?int 
    {
        if(!is_null($id) && $id < 0) throw new Exception(self::INVALID_ID, 400);

        return $id;
    }

    private static function emailValidation(string $email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception(self::INVALID_EMAIL, 400);

        return $email;
    }

    private static function cpfValidation(string $cpf)
    {
        $pattern = '/^\d{3}\.?\d{3}\.?\d{3}\-?\d{2}$/';

        if(!preg_match($pattern, $cpf)) throw new Exception(self::INVALID_CPF, 400);

        $cpf = preg_replace('/[.-]/', '', $cpf);

        return $cpf;
    }

    private static function VerifyPrivileges(string $privileges)
    {
        if(!Privileges::from($privileges)) throw new Exception(self::INVALID_PRIVILEGES, 400);

        return $privileges;
    }

    private static function PasswordStrength(string $password)
    {
        if(!strlen($password) < 8) throw new Exception(self::INVALID_SHORT_PASSWORD, 400);
        if(!preg_match('/[0-9]+/', $password)) throw new Exception(self::INVALID_NOT_NUMBER_IN_PASSWORD, 400);
        if(!preg_match('/[a-zA-Z]+/', $password)) throw new Exception(self::INVALID_NOT_LETTER_IN_PASSWORD, 400);

        return $password;
    }


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'login' => $this->email,
            'password' => $this->password,
            'privileges' => $this->privileges,
            'active' => $this->active
        ];
    }
}