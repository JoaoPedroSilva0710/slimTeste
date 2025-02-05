<?php

declare(strict_types=1);

namespace Tests\Domain\NewUser;

use Tests\TestCase;
use App\Domain\NewUser\User;
use App\Domain\NewUser\Privileges;
use Exception;
use phpDocumentor\Reflection\Types\This;
use PHPUnit\Framework\Attributes\DataProvider;


use function PHPUnit\Framework\assertEquals;

class NewUserTest extends TestCase
{
    public static function NotValidIdsDataProvider(): array
    {
        return [
            'negativeId' => 
                [ 'data' => ['id' => -2, 'name' => "Valid Name", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "Senha123", 'privileges' => Privileges::User, 'active' => true, 'expectedException' => User::INVALID_ID
                ]
                , 'expectedException' => User::INVALID_ID
                ],

            'zeroId' => 
                [ 'data' => ['id' => 0, 'name' => "Valid Name", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "Senha123", 'privileges' => Privileges::User, 'active' => true
                ], 'expectedException' => User::INVALID_ID],

            'overflowInteger' => 
                [ 'data' => ['id' => 2147483648, 'name' => "Valid Name", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "Senha123", 'privileges' => Privileges::User, 'active' => true
                ], 'expectedException' => User::INVALID_ID]
        ];

    }

    
    public static function NotValidNamesDataProvider(): array
    {
        return [

        'notValidNameSpecialCharacter' => 
            [ 'data' => ['id' => 1, 'name' => "Inva!idName", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "Senha123", 'privileges' => Privileges::User, 'active' => true
            ], 'expectedException' => User::INVALID_NAME
            ],

        'notValidNameNumberOnName' => 
            [ 'data' => ['id' => 1, 'name' => "InValid Name1", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "Senha123", 'privileges' => Privileges::User, 'active' => true
            ], 'expectedException' => User::INVALID_NAME
            ]
        ];

    }


        // New NotValidCpfDataProvider
        public static function NotValidCpfDataProvider(): array
        {
            return [
                'notValidCpfLength' => [
                    'data' => ['id' => 1, 'name' => "Valid Name", 'cpf' => "1234567890", 'email' => "joao@example.com", 'password' => "Senha123", 'privileges' => Privileges::User, 'active' => true],
                    'expectedException' => User::INVALID_CPF,
                ],
                'notValidCpfFormat' => [
                    'data' => ['id' => 1, 'name' => "Valid Name", 'cpf' => "1234567890a", 'email' => "joao@example.com", 'password' => "Senha123", 'privileges' => Privileges::User, 'active' => true],
                    'expectedException' => User::INVALID_CPF,
                ],
            ];
        }
    
        // New NotValidEmailDataProvider
        public static function NotValidEmailDataProvider(): array
        {
            return [
                'emailMissingAtSymbol' => [
                    'data' => ['id' => 1, 'name' => "Valid Name", 'cpf' => "12345678909", 'email' => "joaoexample.com", 'password' => "Senha123", 'privileges' => Privileges::User, 'active' => true],
                    'expectedException' => User::INVALID_EMAIL,
                ],
                'emailInvalidFormat' => [
                    'data' => ['id' => 1, 'name' => "Valid Name", 'cpf' => "12345678909", 'email' => "invalid-email", 'password' => "Senha123", 'privileges' => Privileges::User, 'active' => true],
                    'expectedException' => User::INVALID_EMAIL,
                ],
            ];
        }


        public static function NotValidPasswordDataProvider(): array
        {
            return [
                'passwordTooShort' => [
                    'data' => ['id' => 1, 'name' => "Valid Name", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "123", 'privileges' => Privileges::User, 'active' => true],
                    'expectedException' => User::INVALID_SHORT_PASSWORD,
                ],
                'passwordWithoutNumber' => [
                    'data' => ['id' => 1, 'name' => "Valid Name", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "PasswordWithoutNumber", 'privileges' => Privileges::User, 'active' => true],
                    'expectedException' => User::INVALID_NOT_NUMBER_IN_PASSWORD,
                ],
                'passwordWithoutLetter' => [
                    'data' => ['id' => 1, 'name' => "Valid Name", 'cpf' => "12345678909", 'email' => "joao@example.com", 'password' => "12345678", 'privileges' => Privileges::User, 'active' => true],
                    'expectedException' => User::INVALID_NOT_LETTER_IN_PASSWORD,
                ],
            ];
        }

    
    #[DataProvider('NotValidIdsDataProvider')]
    public function testInvalidIds(array $data, string $expectedException)
    {
        $this->expectedExceptionsCreateUser($data, $expectedException);
    }


    #[DataProvider('NotValidNamesDataProvider')]
    public function testInvalidNames(array $data, string $expectedException)
    {
        $this->expectedExceptionsCreateUser($data, $expectedException);
    }


    private function createUser(array $data): User
    {
            return User::create(
            $data['id'],
            $data['name'],
            $data['cpf'],
            $data['email'],
            $data['password'],
            $data['privileges'],
            $data['active']
        );
    }

    #[DataProvider('NotValidCpfDataProvider')]
    public function testInvalidCpf(array $data, string $expectedException)
    {
        $this->expectedExceptionsCreateUser($data, $expectedException);
    }

    #[DataProvider('NotValidEmailDataProvider')]
    public function testInvalidEmail(array $data, string $expectedException)
    {
        $this->expectedExceptionsCreateUser($data, $expectedException);
    }


    private function expectedExceptionsCreateUser(array $data, string $expectedException)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage($expectedException);

        $this->createUser($data);

    }

    #[DataProvider('NotValidPasswordDataProvider')]
    public function testInvalidPassword(array $data, string $expectedException)
    {
        $this->expectedExceptionsCreateUser($data, $expectedException);
    }


}
