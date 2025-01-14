<?php

declare(strict_types=1);

namespace App\Domain\Paciente;

interface PacienteRepositoryInterface
{

    /**
     * @return Paciente[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Paciente
     */
    public function findUserOfId(int $id): array;
}
