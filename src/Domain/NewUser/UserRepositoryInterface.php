<?php

declare(strict_types=1);

namespace App\Domain\NewUser;

use PhpParser\Builder\Function_;

interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): array;

    public function cadastrate(User $user): array;

    public function inactive(int $id): array; 

    public function delete(int $id): array;

    public function update(User $user): array;

    public function login(string $email, string $password): array;

}

