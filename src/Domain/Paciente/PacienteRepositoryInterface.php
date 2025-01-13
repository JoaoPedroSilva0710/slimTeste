<?php

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
    public function findUserOfId(int $id): Paciente;
}
