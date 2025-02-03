<?php

declare(strict_types=1);

namespace Tests\Domain\NewUser;

use Tests\TestCase;
use App\Domain\NewUser\User;
use App\Domain\NewUser\Privileges;

use function PHPUnit\Framework\assertEquals;

class NewUserTest extends TestCase
{
    public function testNameValidation()
    {
        $id = 1; // ou null, se você quiser criar um novo usuário
        $name = "Conceição Sant'anna";
        $cpf = "12345678909"; // Formato válido
        $email = "joao@example.com";
        $password = "Senha123"; // Atende aos critérios de força
        $active = null; // ou false, dependendo do estado desejado
        $privileges = Privileges::tryFrom('user');

        $user = User::create($id, $name, $cpf, $email, $password, $privileges, $active);

        $this->assertEquals($id, $user->id);
        $this->assertEquals($name, $user->name);
        $this->assertEquals($cpf, $user->cpf);
        $this->assertEquals($email, $user->email);
        $this->assertEquals(password_verify($password, $user->password), true);
        $this->assertSame($privileges, $user->privileges);
        $this->assertEquals($active, $user->active);
    }
}
