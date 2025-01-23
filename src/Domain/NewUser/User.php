<?php

declare(strict_types=1);

namespace App\Domain\NewUser;

use Exception;
use JsonSerializable;

class User implements JsonSerializable
{
    const INVALID_ID = 'Este usuário não existe no banco de dados';
    const INVALID_NAME = 'O nome do usuário é inválido';
    const INVALID_SHORT_NAME = 'O nome do paciente deve ter no mínimo 3 caracteres';
    const INVALID_EMAIL = 'Este e-mail é inválido';
    const INVALID_CPF = 'Este CPF é inválido';
    const INVALID_ATIVO = 'O ativo deve ser do tipo booleano';

    private function __construct(public readonly ?int $id, public readonly string $name, public readonly string $cpf, public readonly string $privileges, public readonly string $login, public readonly string $password, public readonly ?bool $active)
    {
        $this->id = $id;
        $this->name = strtolower($name);
        $this->cpf = $cpf;
        $this->privileges = $privileges;
        $this->login = $login;
        $this->password = $password;
    }

    public function create()
    {
        

    }

    private static function nameValidation(string $nome)
    {
        $pattern = '/^[a-záéíóúâêôãõç ]+$/ui';
        if(!preg_match($pattern, $nome)) throw new Exception(self::INVALID_NAME, 400);

        if(strlen($nome) < 3) throw new Exception(self::INVALID_SHORT_NAME, 400);

        return $nome;       
    }
    private static function idValidation(?int $id) : ?int {
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


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'login' => $this->login,
            'password' => $this->password,
            'privileges' => $this->privileges
        ];
    }
}
