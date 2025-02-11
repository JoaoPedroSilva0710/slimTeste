<?php

declare(strict_types=1);

namespace App\Application\Actions\NewUser;

use Psr\Log\LoggerInterface;
use App\Application\Actions\Action;
use App\services\OwnAntixssInterface;
use App\Domain\NewUser\UserRepositoryInterface;

abstract class UserAction extends Action
{
    protected UserRepositoryInterface $userRepository; 

    public function __construct(LoggerInterface $logger, UserRepositoryInterface $userRepository, protected OwnAntixssInterface $antiXss)
    {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
    }

    protected function sanitizeArray(array $array): array
    {
        foreach ($array as &$value) {
            $value = $this->antiXss->clean($value);
        }

        return $array;
    }
}

