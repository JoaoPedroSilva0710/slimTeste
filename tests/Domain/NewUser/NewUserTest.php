<?php

declare(strict_types=1);

namespace Tests\Domain\NewUser;

use Tests\TestCase;
use App\Domain\NewUser\User;
use App\Domain\NewUser\Privileges;
use Exception;
use phpDocumentor\Reflection\Types\This;

use function PHPUnit\Framework\assertEquals;

class NewUserTest extends TestCase
{
    private array $arrayUsers = [
        // Each entry here represents different test cases with expected errors
        'negativeId' => ['id' => -2, 'name' => "Valid Name", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "Senha123", 'expectedException' => User::INVALID_ID],
        'nullId' => ['id' => null, 'name' => "Valid Name", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "Senha123", 'expectedException' => User::INVALID_ID],
        'notValidName' => ['id' => 1, 'name' => "Inva!idName", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "Senha123", 'expectedException' => User::INVALID_NAME],
        'notValidCpf' => ['id' => 1, 'name' => "João", 'cpf' => "1234567890", 'email' => "joao@example.com", 'password' => "Senha123", 'expectedException' => User::INVALID_CPF],
        'emailNotValid' => ['id' => 1, 'name' => "João", 'cpf' => "12345678909", 'email' => "invalid-email", 'password' => "Senha123", 'expectedException' => User::INVALID_EMAIL],
        'passwordIsShort' => ['id' => 1, 'name' => "João", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "123", 'expectedException' => User::INVALID_SHORT_PASSWORD],
        'Valid' => ['id' => 1, 'name' => "João", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "Senha123", 'active' => false, 'expectedException' => null], // Valid case
    ];

    public $privileges = Privileges::User;


    public function testCreate()
    {
        
        $this->expectException(Exception::class);
        
        $this->expectExceptionMessage($this->arrayUsers['negativeId']['expectedException']);

        $user = User::create($this->arrayUsers['negativeId']['id'], $this->arrayUsers['negativeId']['name'], $this->arrayUsers['negativeId']['cpf'], $this->arrayUsers['negativeId']['email'], $this->arrayUsers['negativeId']['password'], $this->privileges, true);


        // $this->assertEquals($this->id, $user->id);
        // $this->assertEquals($this->name, $user->name);
        // $this->assertEquals($this->cpf, $user->cpf);
        // $this->assertEquals($this->email, $user->email);
        // $this->assertEquals(password_verify($this->password, $user->password), true);
        // $this->assertSame($this->privileges, $user->privileges);
        // $this->assertEquals($this->active, $user->active);
        
    }

    

    public function testNullId()
    {
        $this->expectException(Exception::class);
        
        $this->expectExceptionMessage($this->arrayUsers['negativeId']['expectedException']);

        $user = User::create($this->arrayUsers['negativeId']['id'], $this->arrayUsers['negativeId']['name'], $this->arrayUsers['negativeId']['cpf'], $this->arrayUsers['negativeId']['email'], $this->arrayUsers['negativeId']['password'], $this->privileges, true);

    }

}
