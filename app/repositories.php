<?php

declare(strict_types=1);

use DI\ContainerBuilder;
// use App\Domain\User\UserRepository;
// use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Domain\NewUser\UserRepositoryInterface;
use App\Domain\Paciente\PacienteRepositoryInterface;
use App\Infrastructure\Persistence\NewUser\UserRepository;
use App\Infrastructure\Persistence\Paciente\PacienteRepository;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        // UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        PacienteRepositoryInterface::class => \DI\autowire(PacienteRepository::class),
        UserRepositoryInterface::class => \DI\autowire(UserRepository::class)
    ]);
};
