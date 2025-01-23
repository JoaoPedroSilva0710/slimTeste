<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\NewUser;

use App\Domain\NewUser\User;
use App\Domain\NewUser\UserNotFoundException;
use App\Domain\NewUser\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
        /**
     * @var User[]
     */
    private array $users;

    /**
     * @param User[]|null $users
     */
    public function __construct(array $users = null)
    {
        $this->users = $users ?? [
            // 1 => new User(1, 'bill.gates', 'Bill', 'Gates'),
            // 2 => new User(2, 'steve.jobs', 'Steve', 'Jobs'),
            // 3 => new User(3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
            // 4 => new User(4, 'evan.spiegel', 'Evan', 'Spiegel'),
            // 5 => new User(5, 'jack.dorsey', 'Jack', 'Dorsey'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->users);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        if (!isset($this->users[$id])) {
            throw new UserNotFoundException();
        }

        return $this->users[$id];
    }

}
