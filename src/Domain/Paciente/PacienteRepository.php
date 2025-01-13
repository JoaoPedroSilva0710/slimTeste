<?php

declare(strict_types=1);

namespace App\Domain\Paciente;

use Exception;

class PacienteRepository implements PacienteRepositoryInterface
{
    const PACIENT_NOT_FOUND = 'O paciente não foi encontrado';

    // public function __construct(public readonly ?array $pacientes)
    // {
    //     $this->pacientes = $pacientes ?? [
    //         1 => new Paciente(1, 'João', '01-02-2003', 'M', 'Lilian', 'joaosilva@gmail.com', '12345678912', '03343010', 'nome_rua', 'numero_casa', 'bairro do trabalho', 'SP', TRUE),
    //         2 => new Paciente(2, 'Pedro', '01-02-2003', 'M', 'Lilian', 'pedrosilva@gmail.com', '123.456.789-13', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE),
    //         3 => new Paciente(3, 'Lucas', '01-02-2003', 'M', 'Lilian', 'lucasrodrigues@gmail.com', '22345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE),
    //         4 => new Paciente(4, 'Giovani', '01-02-2003', 'M', 'Lilian', 'gurudoexcel@gmail.com', '32345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE),
    //         5 => new Paciente(5, 'Tiago', '01-02-2003', 'M', 'Lilian', 'tiagoletieri@gmail.com', '42345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE),
    //     ];
    // }



    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values([]);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): array
    {
        // if (!isset($this->pacientes[$id])) {
        //     throw new Exception(self::PACIENT_NOT_FOUND);
        // }

        // return $this->pacientes[$id];
        return [];
    }
}
