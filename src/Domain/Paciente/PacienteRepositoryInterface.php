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
    public function findPacienteOfId(int $id): array;

    public function cadastrate(Paciente $paciente): array;

    public function delete(int $id): array;

    public function update(Paciente $paciente): array;

}
