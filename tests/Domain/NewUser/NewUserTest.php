<?php

namespace Tests\Domain\NewUser;

use Tests\TestCase;
use App\Domain\NewUser\User;
use App\Domain\NewUser\Privileges;

class NewUserTest extends TestCase
{
    public function userProvider(): array
    {
        return [
            [1, 'a73d30ff-a991-4f02-8079-2ca5c3bde871', 'joao', '$2y$10$bB3JBIE6SkIvnJ3/S8CwAeSEQqZ9Isi0tF6/SU1vDQZlJzQ8IZqH.', 'joao', '12345678901', 'admin', true],
            // [2, 'steve.jobs', 'Steve', 'Jobs'],
            // [3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'],
            // [4, 'evan.spiegel', 'Evan', 'Spiegel'],
            // [5, 'jack.dorsey', 'Jack', 'Dorsey'],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param int    $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     */
    public function testGetters(?int $id, string $name, string $cpf, string $email, string $password, Privileges $privileges, ?bool $active)
    {
        $user = User::create($id, $name, $cpf, $email, $password, $privileges, $active);
        $this->assertEquals($id, $user->$id);
        $this->assertEquals($id, $user->$name);
        $this->assertEquals($id, $user->$cpf);
        $this->assertEquals($id, $user->$email);
        $this->assertEquals($id, $user->$password);
        $this->assertEquals($id, $user->$active);
        $this->assertEquals($id, $user->$privileges->value);
    }

    /**
     * @dataProvider userProvider
     * @param int    $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     */
    public function testJsonSerialize(?int $id, string $name, string $cpf, string $email, string $password, Privileges $privileges, ?bool $active)
    {
        $user = User::create($id, $name, $cpf, $email, $password, $privileges, $active);

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $name,
            'cpf' => $cpf,
            'email' => $email,
            'password' => $password,
            'privileges' => $privileges,
            'active' => $active,
        ]);

        $this->assertEquals($expectedPayload, json_encode($user));
    }
}
